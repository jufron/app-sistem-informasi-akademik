<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Guru;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface GuruRepositoryInterface
 * 
 * Contract for managing teacher (Guru) database operations.
 */
interface GuruRepositoryInterface
{
    /**
     * Retrieve all teacher records.
     *
     * @return Collection<int, Guru>
     */
    public function getAll(): Collection;

    /**
     * Find a specific teacher record by ID.
     *
     * @param int|string $id
     * @return Guru|null
     */
    public function findById(int|string $id): ?Guru;

    /**
     * Create a new teacher record.
     *
     * @param array $data
     * @return Guru
     */
    public function create(array $data): Guru;

    /**
     * Update an existing teacher record.
     *
     * @param int|string $id
     * @param array $data
     * @return Guru
     */
    public function update(int|string $id, array $data): Guru;
    
    /**
     * Delete a specific teacher record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool;

    /**
     * Count the total number of teachers.
     *
     * @return int
     */
    public function count(): int;

    /**
     * Get a formatted list of teachers structured for the homepage carousel slides.
     *
     * @return array
     */
    public function getTeachersForHomeSlide(): array;

    /**
     * Check if a teacher with 'Kepala Sekolah' type exists, optionally excluding a specific ID.
     *
     * @param int|string|null $excludeId
     * @return bool
     */
    public function hasPrincipal(int|string|null $excludeId = null): bool;

    /**
     * Check if a teacher exists with the given NIP.
     *
     * @param string $nip
     * @return bool
     */
    public function existsByNip(string $nip): bool;

    /**
     * Retrieve multiple teacher records by their IDs.
     *
     * @param array $ids
     * @return Collection<int, Guru>
     */
    public function getByIds(array $ids): Collection;
}

