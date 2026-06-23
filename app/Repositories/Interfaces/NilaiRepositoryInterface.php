<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Models\Nilai;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface NilaiRepositoryInterface
 * 
 * Contract for managing student grade (Nilai) database operations.
 */
interface NilaiRepositoryInterface
{
    /**
     * Retrieve grade records for a specific classroom and subject.
     *
     * @param int|string $ruanganKelasId
     * @param int|string $mataPelajaranId
     * @return Collection<int, Nilai>
     */
    public function getGrades(int|string $ruanganKelasId, int|string $mataPelajaranId): Collection;

    /**
     * Update or create a grade record matching matching attributes.
     *
     * @param array $attributes
     * @param array $values
     * @return Nilai
     */
    public function updateOrCreateGrade(array $attributes, array $values): Nilai;
}
