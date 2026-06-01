<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\RuanganKelas;

interface RuanganKelasServiceInterface
{
    /**
     * Store a new ruangan kelas.
     *
     * @param array $data
     * @return RuanganKelas
     */
    public function store(array $data): RuanganKelas;

    /**
     * Update an existing ruangan kelas.
     *
     * @param RuanganKelas $ruanganKelas
     * @param array $data
     * @return RuanganKelas
     */
    public function update(RuanganKelas $ruanganKelas, array $data): RuanganKelas;

    /**
     * Delete a ruangan kelas.
     *
     * @param RuanganKelas $ruanganKelas
     * @return bool
     */
    public function destroy(RuanganKelas $ruanganKelas): bool;

    /**
     * Bulk delete ruangan kelas entries.
     *
     * @param array $ids
     * @return bool
     */
    public function bulkDestroy(array $ids): bool;
}
