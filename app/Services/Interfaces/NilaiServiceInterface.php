<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\RuanganKelas;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface NilaiServiceInterface
 * 
 * Handles business logic, query calculations, and transaction orchestration for student grades (Nilai).
 */
interface NilaiServiceInterface
{
    /**
     * Retrieve classrooms where the teacher is scheduled to teach.
     *
     * @param int|string $guruId
     * @return Collection<int, RuanganKelas>
     */
    public function getClassroomsForTeacher(int|string $guruId): Collection;

    /**
     * Retrieve subjects taught by the teacher in a specific classroom.
     *
     * @param int|string $guruId
     * @param int|string $ruanganKelasId
     * @return Collection
     */
    public function getSubjectsForTeacherInClassroom(int|string $guruId, int|string $ruanganKelasId): Collection;

    /**
     * Get the student list and their grades for a classroom and subject.
     *
     * @param int|string $ruanganKelasId
     * @param int|string $mataPelajaranId
     * @return array
     */
    public function getGradesSheet(int|string $ruanganKelasId, int|string $mataPelajaranId): array;

    /**
     * Save student grades for a specific classroom and subject.
     *
     * @param int|string $ruanganKelasId
     * @param int|string $mataPelajaranId
     * @param int|string $guruId
     * @param array $gradesData
     * @return void
     */
    public function saveGrades(int|string $ruanganKelasId, int|string $mataPelajaranId, int|string $guruId, array $gradesData): void;
}
