<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Rombel;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface RombelRepositoryInterface
 * 
 * Contract for managing class group (Rombel / Rombongan Belajar) database operations.
 */
interface RombelRepositoryInterface
{
    /**
     * Retrieve all class groups (Rombel).
     *
     * @return Collection<int, Rombel>
     */
    public function getAll(): Collection;

    /**
     * Find a specific class group by its unique identifier.
     *
     * @param int|string $id
     * @return Rombel|null
     */
    public function findById(int|string $id): ?Rombel;

    /**
     * Create and store a new class group.
     *
     * @param array $data Fields and values to save
     * @return Rombel
     */
    public function create(array $data): Rombel;

    /**
     * Update an existing class group record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return Rombel
     */
    public function update(int|string $id, array $data): Rombel;
    
    /**
     * Delete a specific class group record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Count the total number of class group records.
     *
     * @return int
     */
    public function count(): int;
}
