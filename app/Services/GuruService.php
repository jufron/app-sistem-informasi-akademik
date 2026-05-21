<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Guru;
use App\Models\User;
use App\Models\JenisKelamin;
use App\Models\Agama;
use App\Models\MataPelajaran;
use App\Services\Interfaces\GuruServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class GuruService implements GuruServiceInterface
{
    /**
     * Store a new guru and their associated user.
     */
    public function store(array $data, ?UploadedFile $foto): Guru
    {
        return DB::transaction(function () use ($data, $foto) {
            // Create user account
            $user = User::create([
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
            $guru = Guru::create([
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
                $user->update($userData);
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
            $guru->update([
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

            return $guru;
        });
    }

    /**
     * Delete a guru and their associated user.
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
            $deleted = (bool) $guru->delete();
            if ($user) {
                $user->delete();
            }

            return $deleted;
        });
    }

    /**
     * Bulk delete gurus and their associated users.
     */
    public function bulkDestroy(array $ids): bool
    {
        if (count($ids) === 0) {
            return false;
        }

        return DB::transaction(function () use ($ids) {
            $gurus = Guru::whereIn('id', $ids)->get();
            foreach ($gurus as $guru) {
                if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                    Storage::disk('public')->delete($guru->foto);
                }
                $user = $guru->user;
                $guru->mataPelajaran()->detach();
                $guru->delete();
                if ($user) {
                    $user->delete();
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

        // Keep track of any new principal imports within this single session
        // to prevent importing multiple ones if none existed in DB yet.
        $hasPrincipalInDb = Guru::where('tipe', 'Kepala Sekolah')->exists();
        $importedPrincipalInSession = false;

        foreach ($reader->getRecords() as $record) {
            // Trim whitespace from keys and values
            $cleanRecord = [];
            foreach ($record as $key => $val) {
                $cleanRecord[trim((string)$key)] = trim((string)$val);
            }

            // 1. Every required field must not be empty (except NIP and Nama Panggilan)
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

            // 2. Validate email is unique
            $email = $cleanRecord['Email'];
            if (User::where('email', $email)->exists()) {
                $skippedCount++;
                continue;
            }

            // 3. Validate NIP is unique (if provided)
            $nip = $cleanRecord['NIP'] !== '' ? $cleanRecord['NIP'] : null;
            if ($nip !== null && Guru::where('nip', $nip)->exists()) {
                $skippedCount++;
                continue;
            }

            // 4. Validate Tipe Jabatan enum
            $tipe = $cleanRecord['Tipe Jabatan'];
            $allowedTipe = ['Bukan Wali Kelas', 'Wali Kelas', 'Kepala Sekolah'];
            if (!in_array($tipe, $allowedTipe, true)) {
                $skippedCount++;
                continue;
            }

            // 5. Validate single Principal constraint
            if ($tipe === 'Kepala Sekolah') {
                if ($hasPrincipalInDb || $importedPrincipalInSession) {
                    $skippedCount++;
                    continue;
                }
            }

            // 6. Lookups: Gender
            $jkName = $cleanRecord['Jenis Kelamin'];
            $jk = JenisKelamin::where('nama', $jkName)->first();
            if (!$jk) {
                $skippedCount++;
                continue;
            }

            // 7. Lookups: Religion
            $agamaName = $cleanRecord['Agama'];
            $agama = Agama::where('nama', $agamaName)->first();
            if (!$agama) {
                $skippedCount++;
                continue;
            }

            // 8. Lookups: Subjects (comma separated, e.g. "Matematika, Bahasa Inggris")
            $subjectIds = [];
            $subjectsValid = true;
            if (isset($cleanRecord['Mata Pelajaran']) && $cleanRecord['Mata Pelajaran'] !== '') {
                $subjectNames = array_filter(array_map('trim', explode(',', $cleanRecord['Mata Pelajaran'])));
                foreach ($subjectNames as $name) {
                    $sub = MataPelajaran::where('nama', $name)->first();
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

            // All validations passed! Create the records inside a transaction
            try {
                DB::transaction(function () use ($cleanRecord, $email, $nip, $tipe, $jk, $agama, $subjectIds) {
                    // Create associated user account
                    $user = User::create([
                        'name'     => $cleanRecord['Nama Lengkap'],
                        'email'    => $email,
                        'password' => bcrypt('12345678'), // default password
                    ]);

                    // Assign appropriate Spatie role
                    if ($tipe === 'Kepala Sekolah') {
                        $user->assignRole('kepala-sekolah');
                    } else {
                        $user->assignRole('guru');
                    }

                    // Create teacher profile
                    $guru = Guru::create([
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
                        'foto'             => null, // photo is systematically skipped
                        'status'           => $cleanRecord['Status'] !== '' ? $cleanRecord['Status'] : 'Aktif',
                    ]);

                    // Sync subjects many-to-many
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
}


