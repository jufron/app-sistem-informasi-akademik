<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\AnggotaKelas;
use App\Repositories\Interfaces\AnggotaKelasRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class AnggotaKelasRepository
 * 
 * Handles Eloquent database operations for the AnggotaKelas model.
 */
class AnggotaKelasRepository implements AnggotaKelasRepositoryInterface
{
    /**
     * Retrieve all classroom membership records.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return AnggotaKelas::all();
    }

    /**
     * Find a specific classroom membership record by its unique identifier.
     *
     * @param int|string $id
     * @return AnggotaKelas|null
     */
    public function findById(int|string $id): ?AnggotaKelas
    {
        return AnggotaKelas::find($id);
    }

    /**
     * Create and store a new classroom membership.
     *
     * @param array $data Fields and values to save
     * @return AnggotaKelas
     */
    public function create(array $data): AnggotaKelas
    {
        return AnggotaKelas::create($data);
    }

    /**
     * Update an existing classroom membership record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return AnggotaKelas
     */
    public function update(int|string $id, array $data): AnggotaKelas
    {
        $model = AnggotaKelas::findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Delete a specific classroom membership record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $model = AnggotaKelas::findOrFail($id);
        return (bool) $model->delete();
    }

    /**
     * Retrieve all members of a specific classroom.
     *
     * @param int|string $ruanganKelasId
     * @return Collection
     */
    public function getByRuanganKelasId(int|string $ruanganKelasId): Collection
    {
        return AnggotaKelas::with('siswa')->where('ruangan_kelas_id', $ruanganKelasId)->get();
    }

    /**
     * Find the active classroom membership record of a specific student.
     *
     * @param int|string $siswaId
     * @return AnggotaKelas|null
     */
    public function findActiveBySiswaId(int|string $siswaId): ?AnggotaKelas
    {
        return AnggotaKelas::with(['ruanganKelas.kelas', 'ruanganKelas.rombel', 'ruanganKelas.guru'])
            ->where('siswa_id', $siswaId)
            ->first();
    }

    /**
     * Retrieve other students registered in the same classroom.
     *
     * @param int|string $ruanganKelasId
     * @param int|string $excludeSiswaId
     * @return Collection
     */
    public function getClassmates(int|string $ruanganKelasId, int|string $excludeSiswaId): Collection
    {
        return AnggotaKelas::with('siswa.jenisKelamin')
            ->where('ruangan_kelas_id', $ruanganKelasId)
            ->where('siswa_id', '!=', $excludeSiswaId)
            ->get();
    }
}
