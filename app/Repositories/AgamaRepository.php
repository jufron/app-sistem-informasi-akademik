<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Agama;
use App\Repositories\Interfaces\AgamaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class AgamaRepository
 * 
 * Repository implementation for managing Religion (Agama) database operations.
 */
class AgamaRepository implements AgamaRepositoryInterface
{
    /**
     * Retrieve all religion records.
     *
     * @return Collection<int, Agama>
     */
    public function getAll(): Collection
    {
        return Agama::all();
    }

    /**
     * Find a specific religion record by ID.
     *
     * @param int|string $id
     * @return Agama|null
     */
    public function findById(int|string $id): ?Agama
    {
        return Agama::find($id);
    }

    /**
     * Create a new religion record.
     *
     * @param array $data
     * @return Agama
     */
    public function create(array $data): Agama
    {
        return Agama::create($data);
    }

    /**
     * Update an existing religion record.
     *
     * @param int|string $id
     * @param array $data
     * @return Agama
     */
    public function update(int|string $id, array $data): Agama
    {
        $model = Agama::findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Delete a specific religion record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $model = Agama::findOrFail($id);
        return (bool) $model->delete();
    }

    /**
     * Find a religion record by its name.
     *
     * @param string $name
     * @return Agama|null
     */
    public function findByName(string $name): ?Agama
    {
        return Agama::where('nama', $name)->first();
    }
}

