<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface KelasRepositoryInterface
 * 
 * Contract for managing class grade level (Kelas) database operations.
 */
interface KelasRepositoryInterface
{
    /**
     * Retrieve all class grade levels.
     *
     * @return Collection<int, Kelas>
     */
    public function getAll(): Collection;

    /**
     * Find a specific class grade level by its unique identifier.
     *
     * @param int|string $id
     * @return Kelas|null
     */
    public function findById(int|string $id): ?Kelas;

    /**
     * Create and store a new class grade level.
     *
     * @param array $data Fields and values to save
     * @return Kelas
     */
    public function create(array $data): Kelas;

    /**
     * Update an existing class grade level record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return Kelas
     */
    public function update(int|string $id, array $data): Kelas;
    
    /**
     * Delete a specific class grade level record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;
}
