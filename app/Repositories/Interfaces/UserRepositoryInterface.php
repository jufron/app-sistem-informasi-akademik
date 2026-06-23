<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface UserRepositoryInterface
 * 
 * Contract for managing User database operations.
 */
interface UserRepositoryInterface
{
    /**
     * Retrieve all user records.
     *
     * @return Collection<int, User>
     */
    public function getAll(): Collection;

    /**
     * Find a specific user record by ID.
     *
     * @param int|string $id
     * @return User|null
     */
    public function findById(int|string $id): ?User;

    /**
     * Create a new user record.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * Update an existing user record.
     *
     * @param int|string $id
     * @param array $data
     * @return User
     */
    public function update(int|string $id, array $data): User;
    
    /**
     * Delete a specific user record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Check if a user exists with the given email address.
     *
     * @param string $email
     * @return bool
     */
    public function existsByEmail(string $email): bool;
}

