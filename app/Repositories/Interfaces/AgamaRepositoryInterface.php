<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Agama;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface AgamaRepositoryInterface
 * 
 * Contract for managing Religion (Agama) database operations.
 */
interface AgamaRepositoryInterface
{
    /**
     * Retrieve all religion records.
     *
     * @return Collection<int, Agama>
     */
    public function getAll(): Collection;

    /**
     * Find a specific religion record by ID.
     *
     * @param int|string $id
     * @return Agama|null
     */
    public function findById(int|string $id): ?Agama;

    /**
     * Create a new religion record.
     *
     * @param array $data
     * @return Agama
     */
    public function create(array $data): Agama;

    /**
     * Update an existing religion record.
     *
     * @param int|string $id
     * @param array $data
     * @return Agama
     */
    public function update(int|string $id, array $data): Agama;
    
    /**
     * Delete a specific religion record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Find a religion record by its name.
     *
     * @param string $name
     * @return Agama|null
     */
    public function findByName(string $name): ?Agama;
}

