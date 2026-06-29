<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Siswa;
use App\Repositories\Interfaces\SiswaRepositoryInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

/**
 * Class SiswaRepository
 * 
 * Handles Eloquent database operations for the Siswa (Student) model.
 */
class SiswaRepository implements SiswaRepositoryInterface
{
    /**
     * Retrieve all students.
     *
     * @return EloquentCollection
     */
    public function getAll(): EloquentCollection
    {
        return Siswa::all();
    }

    /**
     * Find a specific student by their unique identifier.
     *
     * @param int|string $id
     * @return Siswa|null
     */
    public function findById(int|string $id): ?Siswa
    {
        return Siswa::find($id);
    }

    /**
     * Create and store a new student record.
     *
     * @param array $data Fields and values to save
     * @return Siswa
     */
    public function create(array $data): Siswa
    {
        return Siswa::create($data);
    }

    /**
     * Update an existing student record.
     *
     * @param int|string $id
     * @param array $data Fields and updated values
     * @return Siswa
     */
    public function update(int|string $id, array $data): Siswa
    {
        $model = Siswa::findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Delete a specific student record.
     *
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        $model = Siswa::findOrFail($id);
        return (bool) $model->delete();
    }

    /**
     * Count the total number of students.
     *
     * @return int
     */
    public function count(): int
    {
        return Siswa::count();
    }

    /**
     * Retrieve the distribution of students by gender for analytics.
     *
     * @return SupportCollection
     */
    public function getGenderDistribution(): SupportCollection
    {
        return Siswa::join('jenis_kelamin', 'siswa.jenis_kelamin_id', '=', 'jenis_kelamin.id')
            ->select('jenis_kelamin.nama as name', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin.nama')
            ->get();
    }

    /**
     * Retrieve the distribution of students by religion for analytics.
     *
     * @return SupportCollection
     */
    public function getReligionDistribution(): SupportCollection
    {
        return Siswa::join('agama', 'siswa.agama_id', '=', 'agama.id')
            ->select('agama.nama as name', DB::raw('count(*) as total'))
            ->groupBy('agama.nama')
            ->get();
    }

    /**
     * Retrieve the distribution of students by status (Active/Inactive) for analytics.
     *
     * @return SupportCollection
     */
    public function getStatusDistribution(): SupportCollection
    {
        return Siswa::select('status as name', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
    }

    /**
     * Find a student record by their associated user account ID.
     *
     * @param int|string $userId
     * @return Siswa|null
     */
    public function findByUserId(int|string $userId): ?Siswa
    {
        return Siswa::where('user_id', $userId)->first();
    }

    /**
     * Check if a student exists with the given NISN.
     *
     * @param string $nisn
     * @return bool
     */
    public function existsByNisn(string $nisn): bool
    {
        return Siswa::where('nisn', $nisn)->exists();
    }

    /**
     * Check if a student exists with the given NIS.
     *
     * @param string $nis
     * @return bool
     */
    public function existsByNis(string $nis): bool
    {
        return Siswa::where('nis', $nis)->exists();
    }
}
