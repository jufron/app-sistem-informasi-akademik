<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\MataPelajaran;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface MataPelajaranRepositoryInterface
 * 
 * Contract for managing Subject (MataPelajaran) database operations.
 */
interface MataPelajaranRepositoryInterface
{
    /**
     * Retrieve all subject records.
     *
     * @return Collection<int, MataPelajaran>
     */
    public function getAll(): Collection;

    /**
     * Find a specific subject record by ID.
     *
     * @param int|string $id
     * @return MataPelajaran|null
     */
    public function findById(int|string $id): ?MataPelajaran;

    /**
     * Create a new subject record.
     *
     * @param array $data
     * @return MataPelajaran
     */
    public function create(array $data): MataPelajaran;

    /**
     * Update an existing subject record.
     *
     * @param int|string $id
     * @param array $data
     * @return MataPelajaran
     */
    public function update(int|string $id, array $data): MataPelajaran;
    
    /**
     * Delete a specific subject record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Count the total number of subjects.
     *
     * @return int
     */
    public function count(): int;

    /**
     * Find a subject record by its name.
     *
     * @param string $name
     * @return MataPelajaran|null
     */
    public function findByName(string $name): ?MataPelajaran;
}

