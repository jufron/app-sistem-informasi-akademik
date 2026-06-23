<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\JenisKelamin;
use App\Repositories\Interfaces\JenisKelaminRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class JenisKelaminRepository
 * 
 * Repository implementation for managing Gender (JenisKelamin) database operations.
 */
class JenisKelaminRepository implements JenisKelaminRepositoryInterface
{
    /**
     * Retrieve all gender records.
     *
     * @return Collection<int, JenisKelamin>
     */
    public function getAll(): Collection
    {
        return JenisKelamin::all();
    }

    /**
     * Find a specific gender record by ID.
     *
     * @param int|string $id
     * @return JenisKelamin|null
     */
    public function findById(int|string $id): ?JenisKelamin
    {
        return JenisKelamin::find($id);
    }

    /**
     * Create a new gender record.
     *
     * @param array $data
     * @return JenisKelamin
     */
    public function create(array $data): JenisKelamin
    {
        return JenisKelamin::create($data);
    }

    /**
     * Update an existing gender record.
     *
     * @param int|string $id
     * @param array $data
     * @return JenisKelamin
     */
    public function update(int|string $id, array $data): JenisKelamin
    {
        $model = JenisKelamin::findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Delete a specific gender record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $model = JenisKelamin::findOrFail($id);
        return (bool) $model->delete();
    }

    /**
     * Find a gender record by its name.
     *
     * @param string $name
     * @return JenisKelamin|null
     */
    public function findByName(string $name): ?JenisKelamin
    {
        return JenisKelamin::where('nama', $name)->first();
    }
}

