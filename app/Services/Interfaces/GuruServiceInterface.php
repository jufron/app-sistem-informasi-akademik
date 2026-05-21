<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\Guru;
use Illuminate\Http\UploadedFile;

interface GuruServiceInterface
{
    /**
     * Store a new guru and their associated user.
     *
     * @param array $data
     * @param UploadedFile|null $foto
     * @return Guru
     */
    public function store(array $data, ?UploadedFile $foto): Guru;

    /**
     * Update an existing guru and their associated user.
     *
     * @param Guru $guru
     * @param array $data
     * @param UploadedFile|null $foto
     * @return Guru
     */
    public function update(Guru $guru, array $data, ?UploadedFile $foto): Guru;

    /**
     * Delete a guru and their associated user.
     *
     * @param Guru $guru
     * @return bool
     */
    public function destroy(Guru $guru): bool;

    /**
     * Bulk delete gurus and their associated users.
     *
     * @param array $ids
     * @return bool
     */
    public function bulkDestroy(array $ids): bool;

    /**
     * Import guru records from a CSV file.
     *
     * @param string $filePath
     * @return array{imported: int, skipped: int}
     */
    public function importFromCsv(string $filePath): array;
}


