<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\Siswa;
use Illuminate\Http\UploadedFile;

interface SiswaServiceInterface
{
    /**
     * Store a new student and their associated user.
     *
     * @param array $data
     * @param UploadedFile|null $foto
     * @return Siswa
     */
    public function store(array $data, ?UploadedFile $foto): Siswa;

    /**
     * Update an existing student and their associated user.
     *
     * @param Siswa $siswa
     * @param array $data
     * @param UploadedFile|null $foto
     * @return Siswa
     */
    public function update(Siswa $siswa, array $data, ?UploadedFile $foto): Siswa;

    /**
     * Delete a student and their associated user.
     *
     * @param Siswa $siswa
     * @return bool
     */
    public function destroy(Siswa $siswa): bool;

    /**
     * Bulk delete students and their associated users.
     *
     * @param array $ids
     * @return bool
     */
    public function bulkDestroy(array $ids): bool;

    /**
     * Get form options and requirements data needed to create a new student.
     *
     * @return array
     */
    public function getFormDataForCreate(): array;

    /**
     * Get form options, requirements, and loaded relations needed to edit an existing student.
     *
     * @param Siswa $siswa
     * @return array
     */
    public function getFormDataForEdit(Siswa $siswa): array;

    /**
     * Load relations for student details view.
     *
     * @param Siswa $siswa
     * @return Siswa
     */
    public function getSiswaDetails(Siswa $siswa): Siswa;

    /**
     * Import student records from a CSV file.
     *
     * @param string $filePath
     * @return array{imported: int, skipped: int}
     */
    public function importFromCsv(string $filePath): array;

    /**
     * Stream CSV template writer contents directly to output.
     *
     * @return void
     */
    public function downloadCsvTemplate(): void;
}
