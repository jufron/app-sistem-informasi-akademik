<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Rombel;
use App\Repositories\Interfaces\RombelRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RombelRepository
 * 
 * Handles Eloquent database operations for the Rombel (Class Group / Rombongan Belajar) model.
 */
class RombelRepository implements RombelRepositoryInterface
{
    /**
     * Retrieve all class groups (Rombel).
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Rombel::all();
    }

    /**
     * Find a specific class group by its unique identifier.
     *
     * @param int|string $id
     * @return Rombel|null
     */
    public function findById(int|string $id): ?Rombel
    {
        return Rombel::find($id);
    }

    /**
     * Create and store a new class group.
     *
     * @param array $data Fields and values to save
     * @return Rombel
     */
    public function create(array $data): Rombel
    {
        return Rombel::create($data);
    }

    /**
     * Update an existing class group record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return Rombel
     */
    public function update(int|string $id, array $data): Rombel
    {
        $model = Rombel::findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Delete a specific class group record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $model = Rombel::findOrFail($id);
        return (bool) $model->delete();
    }

    /**
     * Count the total number of class group records.
     *
     * @return int
     */
    public function count(): int
    {
        return Rombel::count();
    }
}
