<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\AnggotaKelas;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface AnggotaKelasRepositoryInterface
 * 
 * Contract for managing classroom membership (Anggota Kelas) database operations.
 */
interface AnggotaKelasRepositoryInterface
{
    /**
     * Retrieve all classroom membership records.
     *
     * @return Collection<int, AnggotaKelas>
     */
    public function getAll(): Collection;

    /**
     * Find a specific classroom membership record by its unique identifier.
     *
     * @param int|string $id
     * @return AnggotaKelas|null
     */
    public function findById(int|string $id): ?AnggotaKelas;

    /**
     * Create and store a new classroom membership.
     *
     * @param array $data Fields and values to save
     * @return AnggotaKelas
     */
    public function create(array $data): AnggotaKelas;

    /**
     * Update an existing classroom membership record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return AnggotaKelas
     */
    public function update(int|string $id, array $data): AnggotaKelas;
    
    /**
     * Delete a specific classroom membership record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Retrieve all members of a specific classroom.
     *
     * @param int|string $ruanganKelasId
     * @return Collection<int, AnggotaKelas>
     */
    public function getByRuanganKelasId(int|string $ruanganKelasId): Collection;

    /**
     * Find the active classroom membership record of a specific student.
     *
     * @param int|string $siswaId
     * @return AnggotaKelas|null
     */
    public function findActiveBySiswaId(int|string $siswaId): ?AnggotaKelas;

    /**
     * Retrieve other students registered in the same classroom.
     *
     * @param int|string $ruanganKelasId
     * @param int|string $excludeSiswaId The current student's ID to exclude
     * @return Collection<int, AnggotaKelas>
     */
    public function getClassmates(int|string $ruanganKelasId, int|string $excludeSiswaId): Collection;
}
