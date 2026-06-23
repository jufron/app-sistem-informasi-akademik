<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;

/**
 * Interface SiswaRepositoryInterface
 * 
 * Contract for managing student (Siswa) profile database operations.
 */
interface SiswaRepositoryInterface
{
    /**
     * Retrieve all students.
     *
     * @return EloquentCollection<int, Siswa>
     */
    public function getAll(): EloquentCollection;

    /**
     * Find a specific student by their unique identifier.
     *
     * @param int|string $id
     * @return Siswa|null
     */
    public function findById(int|string $id): ?Siswa;

    /**
     * Create and store a new student record.
     *
     * @param array $data Fields and values to save
     * @return Siswa
     */
    public function create(array $data): Siswa;

    /**
     * Update an existing student record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return Siswa
     */
    public function update(int|string $id, array $data): Siswa;
    
    /**
     * Delete a specific student record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Count the total number of students.
     *
     * @return int
     */
    public function count(): int;

    /**
     * Retrieve the distribution of students by gender for analytics.
     *
     * @return SupportCollection
     */
    public function getGenderDistribution(): SupportCollection;

    /**
     * Retrieve the distribution of students by religion for analytics.
     *
     * @return SupportCollection
     */
    public function getReligionDistribution(): SupportCollection;

    /**
     * Retrieve the distribution of students by status (Active/Inactive) for analytics.
     *
     * @return SupportCollection
     */
    public function getStatusDistribution(): SupportCollection;

    /**
     * Find a student record by their associated user account ID.
     *
     * @param int|string $userId
     * @return Siswa|null
     */
    public function findByUserId(int|string $userId): ?Siswa;
}
