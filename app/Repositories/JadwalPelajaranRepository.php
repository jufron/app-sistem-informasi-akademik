<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\JadwalPelajaran;
use App\Repositories\Interfaces\JadwalPelajaranRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class JadwalPelajaranRepository
 * 
 * Handles Eloquent database operations for the JadwalPelajaran model.
 */
class JadwalPelajaranRepository implements JadwalPelajaranRepositoryInterface
{
    /**
     * Retrieve all schedule records.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return JadwalPelajaran::all();
    }

    /**
     * Find a specific schedule record by its unique identifier.
     *
     * @param int|string $id
     * @return JadwalPelajaran|null
     */
    public function findById(int|string $id): ?JadwalPelajaran
    {
        return JadwalPelajaran::find($id);
    }

    /**
     * Create and store a new schedule record.
     *
     * @param array $data Fields and values to save
     * @return JadwalPelajaran
     */
    public function create(array $data): JadwalPelajaran
    {
        return JadwalPelajaran::create($data);
    }

    /**
     * Update an existing schedule record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return JadwalPelajaran
     */
    public function update(int|string $id, array $data): JadwalPelajaran
    {
        $model = JadwalPelajaran::findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Delete a specific schedule record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $model = JadwalPelajaran::findOrFail($id);
        return (bool) $model->delete();
    }

    /**
     * Count the total number of class schedules.
     *
     * @return int
     */
    public function count(): int
    {
        return JadwalPelajaran::count();
    }

    /**
     * Retrieve class schedules taught by a specific teacher.
     *
     * @param int|string $guruId
     * @return Collection
     */
    public function getByGuruId(int|string $guruId): Collection
    {
        return JadwalPelajaran::with(['mataPelajaran', 'kelas', 'rombel'])
            ->where('guru_id', $guruId)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai')
            ->get();
    }

    /**
     * Retrieve class schedules for a specific grade level (Kelas) and group (Rombel).
     *
     * @param int|string $kelasId
     * @param int|string $rombelId
     * @return Collection
     */
    public function getByClassAndRombel(int|string $kelasId, int|string $rombelId): Collection
    {
        return JadwalPelajaran::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $kelasId)
            ->where('rombel_id', $rombelId)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai')
            ->get();
    }
}
