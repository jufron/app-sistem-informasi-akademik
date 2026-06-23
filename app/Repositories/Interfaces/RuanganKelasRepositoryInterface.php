<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\RuanganKelas;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface RuanganKelasRepositoryInterface
 * 
 * Contract for managing classroom allocation (Ruangan Kelas) database operations.
 */
interface RuanganKelasRepositoryInterface
{
    /**
     * Retrieve all classroom records.
     *
     * @return Collection<int, RuanganKelas>
     */
    public function getAll(): Collection;

    /**
     * Find a specific classroom record by its unique identifier.
     *
     * @param int|string $id
     * @return RuanganKelas|null
     */
    public function findById(int|string $id): ?RuanganKelas;

    /**
     * Create and store a new classroom record.
     *
     * @param array $data Fields and values to save
     * @return RuanganKelas
     */
    public function create(array $data): RuanganKelas;

    /**
     * Update an existing classroom record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return RuanganKelas
     */
    public function update(int|string $id, array $data): RuanganKelas;
    
    /**
     * Delete a specific classroom record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Count the total number of classroom allocations.
     *
     * @return int
     */
    public function count(): int;

    /**
     * Find the classroom where the given teacher acts as Wali Kelas (homeroom teacher).
     * Includes basic relationship bindings (Kelas and Rombel).
     *
     * @param int|string $guruId
     * @return RuanganKelas|null
     */
    public function findByGuruId(int|string $guruId): ?RuanganKelas;
}
