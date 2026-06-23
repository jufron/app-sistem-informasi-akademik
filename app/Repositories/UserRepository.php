<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserRepository
 * 
 * Repository implementation for managing User database operations.
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * Retrieve all user records.
     *
     * @return Collection<int, User>
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * Find a specific user record by ID.
     *
     * @param int|string $id
     * @return User|null
     */
    public function findById(int|string $id): ?User
    {
        return User::find($id);
    }

    /**
     * Create a new user record.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * Update an existing user record.
     *
     * @param int|string $id
     * @param array $data
     * @return User
     */
    public function update(int|string $id, array $data): User
    {
        $model = User::findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Delete a specific user record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $model = User::findOrFail($id);
        return (bool) $model->delete();
    }

    /**
     * Check if a user exists with the given email address.
     *
     * @param string $email
     * @return bool
     */
    public function existsByEmail(string $email): bool
    {
        return User::where('email', $email)->exists();
    }
}

