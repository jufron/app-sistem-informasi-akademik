<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Semester;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface SemesterRepositoryInterface
 * 
 * Contract for managing academic semester database operations.
 */
interface SemesterRepositoryInterface
{
    /**
     * Retrieve all academic semesters.
     *
     * @return Collection<int, Semester>
     */
    public function getAll(): Collection;

    /**
     * Find a specific academic semester by its unique identifier.
     *
     * @param int|string $id
     * @return Semester|null
     */
    public function findById(int|string $id): ?Semester;

    /**
     * Create and store a new academic semester record.
     *
     * @param array $data Fields and values to save
     * @return Semester
     */
    public function create(array $data): Semester;

    /**
     * Update an existing academic semester record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return Semester
     */
    public function update(int|string $id, array $data): Semester;
    
    /**
     * Delete a specific academic semester record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}
