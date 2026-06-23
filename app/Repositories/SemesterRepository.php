<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Semester;
use App\Repositories\Interfaces\SemesterRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class SemesterRepository
 * 
 * Handles Eloquent database operations for the Semester model.
 */
class SemesterRepository implements SemesterRepositoryInterface
{
    /**
     * Retrieve all academic semesters.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Semester::all();
    }

    /**
     * Find a specific academic semester by its unique identifier.
     *
     * @param int|string $id
     * @return Semester|null
     */
    public function findById(int|string $id): ?Semester
    {
        return Semester::find($id);
    }

    /**
     * Create and store a new academic semester record.
     *
     * @param array $data Fields and values to save
     * @return Semester
     */
    public function create(array $data): Semester
    {
        return Semester::create($data);
    }

    /**
     * Update an existing academic semester record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return Semester
     */
    public function update(int|string $id, array $data): Semester
    {
        $model = Semester::findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Delete a specific academic semester record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $model = Semester::findOrFail($id);
        return (bool) $model->delete();
    }
}
