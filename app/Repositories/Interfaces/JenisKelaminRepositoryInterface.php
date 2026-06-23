<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\JenisKelamin;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface JenisKelaminRepositoryInterface
 * 
 * Contract for managing Gender (JenisKelamin) database operations.
 */
interface JenisKelaminRepositoryInterface
{
    /**
     * Retrieve all gender records.
     *
     * @return Collection<int, JenisKelamin>
     */
    public function getAll(): Collection;

    /**
     * Find a specific gender record by ID.
     *
     * @param int|string $id
     * @return JenisKelamin|null
     */
    public function findById(int|string $id): ?JenisKelamin;

    /**
     * Create a new gender record.
     *
     * @param array $data
     * @return JenisKelamin
     */
    public function create(array $data): JenisKelamin;

    /**
     * Update an existing gender record.
     *
     * @param int|string $id
     * @param array $data
     * @return JenisKelamin
     */
    public function update(int|string $id, array $data): JenisKelamin;
    
    /**
     * Delete a specific gender record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Find a gender record by its name.
     *
     * @param string $name
     * @return JenisKelamin|null
     */
    public function findByName(string $name): ?JenisKelamin;
}

