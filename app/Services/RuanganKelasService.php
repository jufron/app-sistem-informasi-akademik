<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\RuanganKelas;
use App\Services\Interfaces\RuanganKelasServiceInterface;
use Illuminate\Support\Facades\DB;

class RuanganKelasService implements RuanganKelasServiceInterface
{
    /**
     * Store a new ruangan kelas.
     */
    public function store(array $data): RuanganKelas
    {
        return DB::transaction(function () use ($data) {
            $ruanganKelas = RuanganKelas::create([
                'kelas_id'       => $data['kelas_id'],
                'rombel_id'      => $data['rombel_id'],
                'semester_id'    => $data['semester_id'],
                'guru_id'        => $data['guru_id'],
                'tahun_angkatan' => $data['tahun_angkatan'],
                'tahun_ajaran'   => $data['tahun_ajaran'],
                'aktif'          => $data['aktif'] ?? true,
            ]);

            // Save students as anggota_kelas
            if (!empty($data['siswa_ids'])) {
                foreach ($data['siswa_ids'] as $index => $siswaId) {
                    if (empty($siswaId)) {
                        continue;
                    }
                    
                    \App\Models\AnggotaKelas::create([
                        'siswa_id'         => $siswaId,
                        'ruangan_kelas_id' => $ruanganKelas->id,
                        'tanggal_masuk'    => $data['tanggal_masuks'][$index] ?? date('Y-m-d'),
                        'tanggal_keluar'   => $data['tanggal_keluars'][$index] ?? null,
                        'status'           => $data['statuses'][$index] ?? 'Aktif',
                        'keterangan'       => $data['keterangans'][$index] ?? null,
                    ]);
                }
            }


            return $ruanganKelas;
        });
    }


    /**
     * Update an existing ruangan kelas.
     */
    public function update(RuanganKelas $ruanganKelas, array $data): RuanganKelas
    {
        return DB::transaction(function () use ($ruanganKelas, $data) {
            $ruanganKelas->update([
                'kelas_id'       => $data['kelas_id'],
                'rombel_id'      => $data['rombel_id'],
                'semester_id'    => $data['semester_id'],
                'guru_id'        => $data['guru_id'],
                'tahun_angkatan' => $data['tahun_angkatan'],
                'tahun_ajaran'   => $data['tahun_ajaran'],
                'aktif'          => $data['aktif'] ?? true,
            ]);

            // Clear existing students
            \App\Models\AnggotaKelas::where('ruangan_kelas_id', $ruanganKelas->id)->delete();

            // Save students as anggota_kelas
            if (!empty($data['siswa_ids'])) {
                foreach ($data['siswa_ids'] as $index => $siswaId) {
                    if (empty($siswaId)) {
                        continue;
                    }
                    
                    \App\Models\AnggotaKelas::create([
                        'siswa_id'         => $siswaId,
                        'ruangan_kelas_id' => $ruanganKelas->id,
                        'tanggal_masuk'    => $data['tanggal_masuks'][$index] ?? date('Y-m-d'),
                        'tanggal_keluar'   => $data['tanggal_keluars'][$index] ?? null,
                        'status'           => $data['statuses'][$index] ?? 'Aktif',
                        'keterangan'       => $data['keterangans'][$index] ?? null,
                    ]);
                }
            }

            return $ruanganKelas;
        });
    }

    /**
     * Delete a ruangan kelas.
     */
    public function destroy(RuanganKelas $ruanganKelas): bool
    {
        return DB::transaction(function () use ($ruanganKelas) {
            return (bool) $ruanganKelas->delete();
        });
    }

    /**
     * Bulk delete ruangan kelas entries.
     */
    public function bulkDestroy(array $ids): bool
    {
        if (count($ids) === 0) {
            return false;
        }

        return DB::transaction(function () use ($ids) {
            RuanganKelas::whereIn('id', $ids)->delete();
            return true;
        });
    }
}
