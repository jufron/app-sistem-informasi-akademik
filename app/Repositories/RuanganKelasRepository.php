<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\RuanganKelas;
use App\Repositories\Interfaces\RuanganKelasRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RuanganKelasRepository
 * 
 * Handles Eloquent database operations for the RuanganKelas model.
 */
class RuanganKelasRepository implements RuanganKelasRepositoryInterface
{
    /**
     * Retrieve all classroom records.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return RuanganKelas::all();
    }

    /**
     * Find a specific classroom record by its unique identifier.
     *
     * @param int|string $id
     * @return RuanganKelas|null
     */
    public function findById(int|string $id): ?RuanganKelas
    {
        return RuanganKelas::find($id);
    }

    /**
     * Create and store a new classroom record.
     *
     * @param array $data Fields and values to save
     * @return RuanganKelas
     */
    public function create(array $data): RuanganKelas
    {
        return RuanganKelas::create($data);
    }

    /**
     * Update an existing classroom record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return RuanganKelas
     */
    public function update(int|string $id, array $data): RuanganKelas
    {
        $model = RuanganKelas::findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Delete a specific classroom record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $model = RuanganKelas::findOrFail($id);
        return (bool) $model->delete();
    }

    /**
     * Count the total number of classroom allocations.
     *
     * @return int
     */
    public function count(): int
    {
        return RuanganKelas::count();
    }

    /**
     * Find the classroom where the given teacher acts as Wali Kelas.
     *
     * @param int|string $guruId
     * @return RuanganKelas|null
     */
    public function findByGuruId(int|string $guruId): ?RuanganKelas
    {
        return RuanganKelas::with(['kelas', 'rombel'])->where('guru_id', $guruId)->first();
    }
}
