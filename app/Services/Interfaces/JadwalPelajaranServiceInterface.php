<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

use App\Models\JadwalPelajaran;

interface JadwalPelajaranServiceInterface
{
    /**
     * Store a new lesson schedule.
     *
     * @param array $data
     * @return JadwalPelajaran
     */
    public function store(array $data): JadwalPelajaran;

    /**
     * Update an existing lesson schedule.
     *
     * @param JadwalPelajaran $jadwalPelajaran
     * @param array $data
     * @return JadwalPelajaran
     */
    public function update(JadwalPelajaran $jadwalPelajaran, array $data): JadwalPelajaran;

    /**
     * Delete a lesson schedule.
     *
     * @param JadwalPelajaran $jadwalPelajaran
     * @return bool
     */
    public function destroy(JadwalPelajaran $jadwalPelajaran): bool;

    /**
     * Bulk delete lesson schedules.
     *
     * @param array $ids
     * @return bool
     */
    public function bulkDestroy(array $ids): bool;

    /**
     * Get all schedules formatted for FullCalendar.
     *
     * @return array
     */
    public function getEventsForCalendar(): array;
}
