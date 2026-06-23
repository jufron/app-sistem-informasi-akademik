<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Kelas;
use App\Repositories\Interfaces\KelasRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class KelasRepository
 * 
 * Handles Eloquent database operations for the Kelas (Class Grade Level) model.
 */
class KelasRepository implements KelasRepositoryInterface
{
    /**
     * Retrieve all class grade levels.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Kelas::all();
    }

    /**
     * Find a specific class grade level by its unique identifier.
     *
     * @param int|string $id
     * @return Kelas|null
     */
    public function findById(int|string $id): ?Kelas
    {
        return Kelas::find($id);
    }

    /**
     * Create and store a new class grade level.
     *
     * @param array $data Fields and values to save
     * @return Kelas
     */
    public function create(array $data): Kelas
    {
        return Kelas::create($data);
    }

    /**
     * Update an existing class grade level record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return Kelas
     */
    public function update(int|string $id, array $data): Kelas
    {
        $model = Kelas::findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Delete a specific class grade level record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $model = Kelas::findOrFail($id);
        return (bool) $model->delete();
    }
}
