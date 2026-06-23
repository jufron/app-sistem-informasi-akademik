<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\JadwalPelajaran;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface JadwalPelajaranRepositoryInterface
 * 
 * Contract for managing class schedule (Jadwal Pelajaran) database operations.
 */
interface JadwalPelajaranRepositoryInterface
{
    /**
     * Retrieve all schedule records.
     *
     * @return Collection<int, JadwalPelajaran>
     */
    public function getAll(): Collection;

    /**
     * Find a specific schedule record by its unique identifier.
     *
     * @param int|string $id
     * @return JadwalPelajaran|null
     */
    public function findById(int|string $id): ?JadwalPelajaran;

    /**
     * Create and store a new schedule record.
     *
     * @param array $data Fields and values to save
     * @return JadwalPelajaran
     */
    public function create(array $data): JadwalPelajaran;

    /**
     * Update an existing schedule record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return JadwalPelajaran
     */
    public function update(int|string $id, array $data): JadwalPelajaran;
    
    /**
     * Delete a specific schedule record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Count the total number of class schedules.
     *
     * @return int
     */
    public function count(): int;

    /**
     * Retrieve class schedules taught by a specific teacher.
     * Ordered by day of the week and starting time.
     *
     * @param int|string $guruId
     * @return Collection<int, JadwalPelajaran>
     */
    public function getByGuruId(int|string $guruId): Collection;

    /**
     * Retrieve class schedules for a specific grade level (Kelas) and group (Rombel).
     * Ordered by day of the week and starting time.
     *
     * @param int|string $kelasId
     * @param int|string $rombelId
     * @return Collection<int, JadwalPelajaran>
     */
    public function getByClassAndRombel(int|string $kelasId, int|string $rombelId): Collection;
}
