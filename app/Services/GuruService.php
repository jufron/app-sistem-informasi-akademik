<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Guru;
use App\Services\Interfaces\GuruServiceInterface;
use App\Repositories\Interfaces\GuruRepositoryInterface;
use App\Repositories\Interfaces\JenisKelaminRepositoryInterface;
use App\Repositories\Interfaces\AgamaRepositoryInterface;
use App\Repositories\Interfaces\MataPelajaranRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Writer;

/**
 * Class GuruService
 * 
 * Handles business logic, CSV parsing/importing, templates, and transaction management for teachers.
 */
class GuruService implements GuruServiceInterface
{
    /**
     * Create a new service instance.
     * 
     * Injects the required repository contracts using constructor property promotion.
     * 
     * @param GuruRepositoryInterface $guruRepo
     * @param JenisKelaminRepositoryInterface $jenisKelaminRepo
     * @param AgamaRepositoryInterface $agamaRepo
     * @param MataPelajaranRepositoryInterface $mataPelajaranRepo
     * @param UserRepositoryInterface $userRepo
     */
    public function __construct(
        protected GuruRepositoryInterface $guruRepo,
        protected JenisKelaminRepositoryInterface $jenisKelaminRepo,
        protected AgamaRepositoryInterface $agamaRepo,
        protected MataPelajaranRepositoryInterface $mataPelajaranRepo,
        protected UserRepositoryInterface $userRepo
    ) {}

    /**
     * Store a new guru and their associated user.
     *
     * @param array $data
     * @param UploadedFile|null $foto
     * @return Guru
     */
    public function store(array $data, ?UploadedFile $foto): Guru
    {
        return DB::transaction(function () use ($data, $foto) {
            // Create user account
            $user = $this->userRepo->create([
                'name'     => $data['nama_lengkap'],
                'email'    => $data['email'],
                'password' => bcrypt($data['password']),
            ]);
            
            if ($data['tipe'] === 'Kepala Sekolah') {
                $user->assignRole('kepala-sekolah');
            } else {
                $user->assignRole('guru');
            }

            // Handle photo upload
            $fotoPath = null;
            if ($foto) {
                $fotoPath = $foto->store('guru-foto', 'public');
            }

            // Create teacher profile
            $guru = $this->guruRepo->create([
                'user_id'          => $user->id,
                'nip'              => $data['nip'],
                'nama_lengkap'     => $data['nama_lengkap'],
                'nama_panggilan'   => $data['nama_panggilan'] ?? null,
                'jenis_kelamin_id' => $data['jenis_kelamin_id'],
                'agama_id'         => $data['agama_id'],
                'tempat_lahir'     => $data['tempat_lahir'],
                'tanggal_lahir'    => $data['tanggal_lahir'],
                'telepon'          => $data['telepon'],
                'alamat'           => $data['alamat'],
                'tipe'             => $data['tipe'],
                'foto'             => $fotoPath,
                'status'           => $data['status'],
            ]);

            // Sync subjects many-to-many
            if (!empty($data['mata_pelajaran_ids'])) {
                $guru->mataPelajaran()->sync($data['mata_pelajaran_ids']);
            }

            return $guru;
        });
    }

    /**
     * Update an existing guru and their associated user.
     *
     * @param Guru $guru
     * @param array $data
     * @param UploadedFile|null $foto
     * @return Guru
     */
    public function update(Guru $guru, array $data, ?UploadedFile $foto): Guru
    {
        return DB::transaction(function () use ($guru, $data, $foto) {
            // Update user account details
            $user = $guru->user;
            $userData = [
                'name'  => $data['nama_lengkap'],
                'email' => $data['email'],
            ];
            if (!empty($data['password'])) {
                $userData['password'] = bcrypt($data['password']);
            }
            if ($user) {
                $this->userRepo->update($user->id, $userData);
                if ($data['tipe'] === 'Kepala Sekolah') {
                    $user->syncRoles(['kepala-sekolah']);
                } else {
                    $user->syncRoles(['guru']);
                }
            }

            // Handle photo upload and replacement
            $fotoPath = $guru->foto;
            if ($foto) {
                if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                    Storage::disk('public')->delete($guru->foto);
                }
                $fotoPath = $foto->store('guru-foto', 'public');
            }

            // Update teacher profile details
            $this->guruRepo->update($guru->id, [
                'nip'              => $data['nip'],
                'nama_lengkap'     => $data['nama_lengkap'],
                'nama_panggilan'   => $data['nama_panggilan'] ?? null,
                'jenis_kelamin_id' => $data['jenis_kelamin_id'],
                'agama_id'         => $data['agama_id'],
                'tempat_lahir'     => $data['tempat_lahir'],
                'tanggal_lahir'    => $data['tanggal_lahir'],
                'telepon'          => $data['telepon'],
                'alamat'           => $data['alamat'],
                'tipe'             => $data['tipe'],
                'foto'             => $fotoPath,
                'status'           => $data['status'],
            ]);

            // Sync subjects many-to-many
            if (isset($data['mata_pelajaran_ids'])) {
                $guru->mataPelajaran()->sync($data['mata_pelajaran_ids']);
            } else {
                $guru->mataPelajaran()->detach();
            }

            return $guru->refresh();
        });
    }

    /**
     * Delete a guru and their associated user.
     *
     * @param Guru $guru
     * @return bool
     */
    public function destroy(Guru $guru): bool
    {
        return DB::transaction(function () use ($guru) {
            // Delete photo file
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }

            // Delete relationships and records
            $user = $guru->user;
            $guru->mataPelajaran()->detach();
            $deleted = $this->guruRepo->delete($guru->id);
            if ($user) {
                $this->userRepo->delete($user->id);
            }

            return $deleted;
        });
    }

    /**
     * Bulk delete gurus and their associated users.
     *
     * @param array $ids
     * @return bool
     */
    public function bulkDestroy(array $ids): bool
    {
        if (count($ids) === 0) {
            return false;
        }

        return DB::transaction(function () use ($ids) {
            $gurus = $this->guruRepo->getByIds($ids);
            foreach ($gurus as $guru) {
                if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                    Storage::disk('public')->delete($guru->foto);
                }
                $user = $guru->user;
                $guru->mataPelajaran()->detach();
                $this->guruRepo->delete($guru->id);
                if ($user) {
                    $this->userRepo->delete($user->id);
                }
            }
            return true;
        });
    }

    /**
     * Import guru records from a CSV file.
     *
     * @param string $filePath
     * @return array{imported: int, skipped: int}
     */
    public function importFromCsv(string $filePath): array
    {
        $reader = Reader::createFromPath($filePath, 'r');
        $reader->setHeaderOffset(0);

        $importedCount = 0;
        $skippedCount = 0;

        $hasPrincipalInDb = $this->guruRepo->hasPrincipal();
        $importedPrincipalInSession = false;

        foreach ($reader->getRecords() as $record) {
            // Trim whitespace from keys and values
            $cleanRecord = [];
            foreach ($record as $key => $val) {
                $cleanRecord[trim((string)$key)] = trim((string)$val);
            }

            $requiredColumns = [
                'Email', 'Nama Lengkap', 'Jenis Kelamin', 'Agama', 
                'Tempat Lahir', 'Tanggal Lahir', 'Telepon', 'Alamat', 'Tipe Jabatan'
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

            $nip = $cleanRecord['NIP'] !== '' ? $cleanRecord['NIP'] : null;
            if ($nip !== null && $this->guruRepo->existsByNip($nip)) {
                $skippedCount++;
                continue;
            }

            $tipe = $cleanRecord['Tipe Jabatan'];
            $allowedTipe = ['Bukan Wali Kelas', 'Wali Kelas', 'Kepala Sekolah'];
            if (!in_array($tipe, $allowedTipe, true)) {
                $skippedCount++;
                continue;
            }

            if ($tipe === 'Kepala Sekolah') {
                if ($hasPrincipalInDb || $importedPrincipalInSession) {
                    $skippedCount++;
                    continue;
                }
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

            $subjectIds = [];
            $subjectsValid = true;
            if (isset($cleanRecord['Mata Pelajaran']) && $cleanRecord['Mata Pelajaran'] !== '') {
                $subjectNames = array_filter(array_map('trim', explode(',', $cleanRecord['Mata Pelajaran'])));
                foreach ($subjectNames as $name) {
                    $sub = $this->mataPelajaranRepo->findByName($name);
                    if (!$sub) {
                        $subjectsValid = false;
                        break;
                    }
                    $subjectIds[] = $sub->id;
                }
            }

            if (!$subjectsValid) {
                $skippedCount++;
                continue;
            }

            try {
                DB::transaction(function () use ($cleanRecord, $email, $nip, $tipe, $jk, $agama, $subjectIds) {
                    // Create associated user account
                    $user = $this->userRepo->create([
                        'name'     => $cleanRecord['Nama Lengkap'],
                        'email'    => $email,
                        'password' => bcrypt('12345678'), // default password
                    ]);

                    if ($tipe === 'Kepala Sekolah') {
                        $user->assignRole('kepala-sekolah');
                    } else {
                        $user->assignRole('guru');
                    }

                    // Create teacher profile
                    $guru = $this->guruRepo->create([
                        'user_id'          => $user->id,
                        'nip'              => $nip,
                        'nama_lengkap'     => $cleanRecord['Nama Lengkap'],
                        'nama_panggilan'   => $cleanRecord['Nama Panggilan'] !== '' ? $cleanRecord['Nama Panggilan'] : null,
                        'jenis_kelamin_id' => $jk->id,
                        'agama_id'         => $agama->id,
                        'tempat_lahir'     => $cleanRecord['Tempat Lahir'],
                        'tanggal_lahir'    => $cleanRecord['Tanggal Lahir'],
                        'telepon'          => $cleanRecord['Telepon'],
                        'alamat'           => $cleanRecord['Alamat'],
                        'tipe'             => $tipe,
                        'foto'             => null,
                        'status'           => $cleanRecord['Status'] !== '' ? $cleanRecord['Status'] : 'Aktif',
                    ]);

                    if (!empty($subjectIds)) {
                        $guru->mataPelajaran()->sync($subjectIds);
                    }
                });

                if ($tipe === 'Kepala Sekolah') {
                    $importedPrincipalInSession = true;
                }

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
     * Get form options and requirements data needed to create a new teacher.
     *
     * @return array
     */
    public function getFormDataForCreate(): array
    {
        return [
            'jenisKelamin'     => $this->jenisKelaminRepo->getAll(),
            'agama'            => $this->agamaRepo->getAll(),
            'mataPelajaran'    => $this->mataPelajaranRepo->getAll(),
            'hasKepalaSekolah' => $this->guruRepo->hasPrincipal(),
        ];
    }

    /**
     * Get form options, requirements, and loaded relations needed to edit an existing teacher.
     *
     * @param Guru $guru
     * @return array
     */
    public function getFormDataForEdit(Guru $guru): array
    {
        return [
            'guru'             => $guru->load(['user', 'mataPelajaran']),
            'jenisKelamin'     => $this->jenisKelaminRepo->getAll(),
            'agama'            => $this->agamaRepo->getAll(),
            'mataPelajaran'    => $this->mataPelajaranRepo->getAll(),
            'hasKepalaSekolah' => $this->guruRepo->hasPrincipal($guru->id),
        ];
    }

    /**
     * Load relations for teacher details view.
     *
     * @param Guru $guru
     * @return Guru
     */
    public function getGuruDetails(Guru $guru): Guru
    {
        return $guru->load(['user', 'jenisKelamin', 'agama', 'mataPelajaran']);
    }

    /**
     * Stream CSV template writer contents directly to output.
     *
     * @return void
     */
    public function downloadCsvTemplate(): void
    {
        $writer = Writer::createFromPath('php://output', 'w');
        
        $writer->insertOne([
            'Email', 'NIP', 'Nama Lengkap', 'Nama Panggilan', 'Jenis Kelamin', 
            'Agama', 'Tempat Lahir', 'Tanggal Lahir', 'Telepon', 'Alamat', 
            'Tipe Jabatan', 'Status', 'Mata Pelajaran'
        ]);

        $writer->insertOne([
            'antonius@mail.com',
            '198503122010011002',
            'Antonius Budi, S.Pd',
            'Anton',
            'Laki-laki',
            'Katolik',
            'Weetabula',
            '1985-03-12',
            '081234567890',
            'Jl. Melati No. 12, Weetabula',
            'Wali Kelas',
            'Aktif',
            'Matematika, Ilmu Pengetahuan Alam dan Sosial (IPAS)'
        ]);
    }
}
