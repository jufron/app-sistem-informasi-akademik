<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\MataPelajaran;
use App\Repositories\Interfaces\MataPelajaranRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class MataPelajaranRepository
 * 
 * Repository implementation for managing Subject (MataPelajaran) database operations.
 */
class MataPelajaranRepository implements MataPelajaranRepositoryInterface
{
    /**
     * Retrieve all subject records.
     *
     * @return Collection<int, MataPelajaran>
     */
    public function getAll(): Collection
    {
        return MataPelajaran::all();
    }

    /**
     * Find a specific subject record by ID.
     *
     * @param int|string $id
     * @return MataPelajaran|null
     */
    public function findById(int|string $id): ?MataPelajaran
    {
        return MataPelajaran::find($id);
    }

    /**
     * Create a new subject record.
     *
     * @param array $data
     * @return MataPelajaran
     */
    public function create(array $data): MataPelajaran
    {
        return MataPelajaran::create($data);
    }

    /**
     * Update an existing subject record.
     *
     * @param int|string $id
     * @param array $data
     * @return MataPelajaran
     */
    public function update(int|string $id, array $data): MataPelajaran
    {
        $model = MataPelajaran::findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Delete a specific subject record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $model = MataPelajaran::findOrFail($id);
        return (bool) $model->delete();
    }

    /**
     * Count the total number of subjects.
     *
     * @return int
     */
    public function count(): int
    {
        return MataPelajaran::count();
    }

    /**
     * Find a subject record by its name.
     *
     * @param string $name
     * @return MataPelajaran|null
     */
    public function findByName(string $name): ?MataPelajaran
    {
        return MataPelajaran::where('nama', $name)->first();
    }
}

