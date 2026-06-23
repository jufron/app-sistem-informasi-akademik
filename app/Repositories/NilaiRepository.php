<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Nilai;
use App\Repositories\Interfaces\NilaiRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class NilaiRepository
 * 
 * Repository implementation for managing student grade (Nilai) database operations.
 */
class NilaiRepository implements NilaiRepositoryInterface
{
    /**
     * Retrieve grade records for a specific classroom and subject.
     *
     * @param int|string $ruanganKelasId
     * @param int|string $mataPelajaranId
     * @return Collection<int, Nilai>
     */
    public function getGrades(int|string $ruanganKelasId, int|string $mataPelajaranId): Collection
    {
        return Nilai::where('ruangan_kelas_id', $ruanganKelasId)
            ->where('mata_pelajaran_id', $mataPelajaranId)
            ->get();
    }

    /**
     * Update or create a grade record matching matching attributes.
     *
     * @param array $attributes
     * @param array $values
     * @return Nilai
     */
    public function updateOrCreateGrade(array $attributes, array $values): Nilai
    {
        return Nilai::updateOrCreate($attributes, $values);
    }
}
