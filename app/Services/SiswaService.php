<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Siswa;
use App\Services\Interfaces\SiswaServiceInterface;
use App\Repositories\Interfaces\SiswaRepositoryInterface;
use App\Repositories\Interfaces\JenisKelaminRepositoryInterface;
use App\Repositories\Interfaces\AgamaRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Writer;

/**
 * Class SiswaService
 *
 * Handles core business operations, transaction management, data validation, photo assets,
 * and bulk import/export workflows for students (Siswa).
 */
class SiswaService implements SiswaServiceInterface
{
    /**
     * Create a new service instance.
     *
     * Injects the required repository contracts using constructor property promotion.
     *
     * @param SiswaRepositoryInterface $siswaRepo Repository handling student database operations
     * @param JenisKelaminRepositoryInterface $jenisKelaminRepo Repository handling gender lookup database operations
     * @param AgamaRepositoryInterface $agamaRepo Repository handling religion lookup database operations
     * @param UserRepositoryInterface $userRepo Repository handling user account database operations
     */
    public function __construct(
        protected SiswaRepositoryInterface $siswaRepo,
        protected JenisKelaminRepositoryInterface $jenisKelaminRepo,
        protected AgamaRepositoryInterface $agamaRepo,
        protected UserRepositoryInterface $userRepo
    ) {}

    /**
     * Store a new student profile and their associated user account within a transaction.
     *
     * @param array $data Validated input array containing student and credentials details
     * @param UploadedFile|null $foto Uploaded photo file instance
     * @return Siswa Stored student instance
     */
    public function store(array $data, ?UploadedFile $foto): Siswa
    {
        return DB::transaction(function () use ($data, $foto) {
            // Create user account
            $user = $this->userRepo->create([
                'name'     => $data['nama_lengkap'],
                'email'    => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            
            $user->assignRole('siswa');

            // Handle photo upload
            $fotoPath = null;
            if ($foto) {
                $fotoPath = $foto->store('siswa-foto', 'public');
            }

            // Create student profile
            $siswa = $this->siswaRepo->create([
                'user_id'          => $user->id,
                'nisn'             => $data['nisn'] ?? null,
                'nis'              => $data['nis'] ?? null,
                'nama_lengkap'     => $data['nama_lengkap'],
                'nama_panggilan'   => $data['nama_panggilan'] ?? null,
                'jenis_kelamin_id' => $data['jenis_kelamin_id'],
                'agama_id'         => $data['agama_id'],
                'tempat_lahir'     => $data['tempat_lahir'],
                'tanggal_lahir'    => $data['tanggal_lahir'],
                'telepon'          => $data['telepon'] ?? null,
                'alamat'           => $data['alamat'],
                'foto'             => $fotoPath,
                'status'           => $data['status'] ?? 'Aktif',
            ]);

            return $siswa;
        });
    }

    /**
     * Update an existing student record and their associated user account within a transaction.
     *
     * @param Siswa $siswa Student model instance to update
     * @param array $data Validated input array containing modified fields
     * @param UploadedFile|null $foto New uploaded photo file instance (replaces old one if present)
     * @return Siswa Updated student instance
     */
    public function update(Siswa $siswa, array $data, ?UploadedFile $foto): Siswa
    {
        return DB::transaction(function () use ($siswa, $data, $foto) {
            // Update user account details
            $user = $siswa->user;
            $userData = [
                'name'  => $data['nama_lengkap'],
                'email' => $data['email'],
            ];
            if (!empty($data['password'])) {
                $userData['password'] = bcrypt($data['password']);
            }
            if ($user) {
                $this->userRepo->update($user->id, $userData);
            }

            // Handle photo upload and replacement
            $fotoPath = $siswa->foto;
            if ($foto) {
                if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                    Storage::disk('public')->delete($siswa->foto);
                }
                $fotoPath = $foto->store('siswa-foto', 'public');
            }

            // Update student profile details
            $this->siswaRepo->update($siswa->id, [
                'nisn'             => $data['nisn'] ?? null,
                'nis'              => $data['nis'] ?? null,
                'nama_lengkap'     => $data['nama_lengkap'],
                'nama_panggilan'   => $data['nama_panggilan'] ?? null,
                'jenis_kelamin_id' => $data['jenis_kelamin_id'],
                'agama_id'         => $data['agama_id'],
                'tempat_lahir'     => $data['tempat_lahir'],
                'tanggal_lahir'    => $data['tanggal_lahir'],
                'telepon'          => $data['telepon'] ?? null,
                'alamat'           => $data['alamat'],
                'foto'             => $fotoPath,
                'status'           => $data['status'] ?? 'Aktif',
            ]);

            return $siswa->refresh();
        });
    }

    /**
     * Delete a student profile, their photo, and their associated user account within a transaction.
     *
     * @param Siswa $siswa Student model instance to delete
     * @return bool True on success, false otherwise
     */
    public function destroy(Siswa $siswa): bool
    {
        return DB::transaction(function () use ($siswa) {
            // Delete photo file
            if ($siswa->foto && Storage::disk('public')->exists($siswa->foto)) {
                Storage::disk('public')->delete($siswa->foto);
            }

            $user = $siswa->user;
            $deleted = $this->siswaRepo->delete($siswa->id);
            if ($user) {
                $this->userRepo->delete($user->id);
            }

            return $deleted;
        });
    }

    /**
     * Delete multiple student records in bulk.
     *
     * @param array $ids Array of student IDs
     * @return bool True if operations executed successfully, false if no IDs provided
     */
    public function bulkDestroy(array $ids): bool
    {
        if (count($ids) === 0) {
            return false;
        }

        return DB::transaction(function () use ($ids) {
            foreach ($ids as $id) {
                $siswa = $this->siswaRepo->findById($id);
                if ($siswa) {
                    $this->destroy($siswa);
                }
            }
            return true;
        });
    }

    /**
     * Retrieve dropdown lists (Genders, Religions) required to render the student creation form.
     *
     * @return array Array containing collection list of genders and religions
     */
    public function getFormDataForCreate(): array
    {
        return [
            'jenisKelamin' => $this->jenisKelaminRepo->getAll(),
            'agama'        => $this->agamaRepo->getAll(),
        ];
    }

    /**
     * Retrieve dropdown lists and load student relations required to render the edit form.
     *
     * @param Siswa $siswa Student model instance
     * @return array Array containing loaded student data, genders, and religions collection
     */
    public function getFormDataForEdit(Siswa $siswa): array
    {
        return [
            'siswa'        => $siswa->load('user'),
            'jenisKelamin' => $this->jenisKelaminRepo->getAll(),
            'agama'        => $this->agamaRepo->getAll(),
        ];
    }

    /**
     * Retrieve a student loaded with their associated lookup data (User, Gender, Religion).
     *
     * @param Siswa $siswa Student model instance
     * @return Siswa Student model instance with loaded relations
     */
    public function getSiswaDetails(Siswa $siswa): Siswa
    {
        return $siswa->load(['user', 'jenisKelamin', 'agama']);
    }

    /**
     * Parse and import student records from a standard CSV file path.
     *
     * @param string $filePath Absolute path to the CSV file on the server
     * @return array{imported: int, skipped: int} Stats of successfully imported and skipped rows
     */
    public function importFromCsv(string $filePath): array
    {
        $reader = Reader::createFromPath($filePath, 'r');
        $reader->setHeaderOffset(0);

        $importedCount = 0;
        $skippedCount = 0;

        foreach ($reader->getRecords() as $record) {
            $cleanRecord = [];
            foreach ($record as $key => $val) {
                $cleanRecord[trim((string)$key)] = trim((string)$val);
            }

            $requiredColumns = [
                'Email', 'Nama Lengkap', 'Jenis Kelamin', 'Agama', 
                'Tempat Lahir', 'Tanggal Lahir', 'Alamat'
            ];

            $hasEmptyField = false;
            foreach ($requiredColumns as $col) {
                if (!isset($cleanRecord[$col]) || $cleanRecord[$col] === '') {
                    $hasEmptyField = true;
                    break;
                }
            }

            if ($hasEmptyField) {
                $skippedCount++;
                continue;
            }

            $email = $cleanRecord['Email'];
            if ($this->userRepo->existsByEmail($email)) {
                $skippedCount++;
                continue;
            }

            $nisn = $cleanRecord['NISN'] !== '' ? $cleanRecord['NISN'] : null;
            if ($nisn !== null && $this->siswaRepo->existsByNisn($nisn)) {
                $skippedCount++;
                continue;
            }

            $nis = $cleanRecord['NIS'] !== '' ? $cleanRecord['NIS'] : null;
            if ($nis !== null && $this->siswaRepo->existsByNis($nis)) {
                $skippedCount++;
                continue;
            }

            $jkName = $cleanRecord['Jenis Kelamin'];
            $jk = $this->jenisKelaminRepo->findByName($jkName);
            if (!$jk) {
                $skippedCount++;
                continue;
            }

            $agamaName = $cleanRecord['Agama'];
            $agama = $this->agamaRepo->findByName($agamaName);
            if (!$agama) {
                $skippedCount++;
                continue;
            }

            try {
                DB::transaction(function () use ($cleanRecord, $email, $nisn, $nis, $jk, $agama) {
                    $user = $this->userRepo->create([
                        'name'     => $cleanRecord['Nama Lengkap'],
                        'email'    => $email,
                        'password' => bcrypt($cleanRecord['Password'] !== '' ? $cleanRecord['Password'] : '12345678'),
                    ]);

                    $user->assignRole('siswa');

                    $this->siswaRepo->create([
                        'user_id'          => $user->id,
                        'nisn'             => $nisn,
                        'nis'              => $nis,
                        'nama_lengkap'     => $cleanRecord['Nama Lengkap'],
                        'nama_panggilan'   => $cleanRecord['Nama Panggilan'] !== '' ? $cleanRecord['Nama Panggilan'] : null,
                        'jenis_kelamin_id' => $jk->id,
                        'agama_id'         => $agama->id,
                        'tempat_lahir'     => $cleanRecord['Tempat Lahir'],
                        'tanggal_lahir'    => $cleanRecord['Tanggal Lahir'],
                        'telepon'          => $cleanRecord['Telepon'] !== '' ? $cleanRecord['Telepon'] : null,
                        'alamat'           => $cleanRecord['Alamat'],
                        'foto'             => null,
                        'status'           => $cleanRecord['Status'] !== '' ? $cleanRecord['Status'] : 'Aktif',
                    ]);
                });

                $importedCount++;
            } catch (\Exception $e) {
                $skippedCount++;
            }
        }

        return [
            'imported' => $importedCount,
            'skipped'  => $skippedCount,
        ];
    }

    /**
     * Write standard student import headers and a sample row to standard streamed output.
     *
     * @return void
     */
    public function downloadCsvTemplate(): void
    {
        $writer = Writer::createFromPath('php://output', 'w');
        
        $writer->insertOne([
            'Email', 'Password', 'NISN', 'NIS', 'Nama Lengkap', 'Nama Panggilan', 
            'Jenis Kelamin', 'Agama', 'Tempat Lahir', 'Tanggal Lahir', 'Telepon', 
            'Alamat', 'Status'
        ]);

        $writer->insertOne([
            'siswa.baru@mail.com',
            '12345678',
            '0123456789',
            '20230005',
            'Rian Hidayat',
            'Rian',
            'Laki-laki',
            'Islam',
            'Sumba',
            '2012-04-15',
            '081298765432',
            'Jl. Mawar No. 4, Sumba',
            'Aktif'
        ]);
    }
}
