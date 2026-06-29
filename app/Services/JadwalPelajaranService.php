<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\JadwalPelajaran;
use App\Services\Interfaces\JadwalPelajaranServiceInterface;
use Illuminate\Support\Facades\DB;

class JadwalPelajaranService implements JadwalPelajaranServiceInterface
{
    /**
     * Store a new lesson schedule.
     */
    public function store(array $data): JadwalPelajaran
    {
        return DB::transaction(function () use ($data) {
            return JadwalPelajaran::create([
                'guru_id'           => $data['guru_id'],
                'mata_pelajaran_id' => $data['mata_pelajaran_id'],
                'kelas_id'          => $data['kelas_id'],
                'rombel_id'         => $data['rombel_id'],
                'semester_id'       => $data['semester_id'],
                'ganjil_genap'      => $data['ganjil_genap'],
                'hari'              => $data['hari'],
                'jam_mulai'         => $data['jam_mulai'],
                'jam_selesai'       => $data['jam_selesai'],
                'ruangan'           => $data['ruangan'] ?? null,
                'warna'             => $data['warna'] ?? '#1572e8',
            ]);
        });
    }

    /**
     * Update an existing lesson schedule.
     */
    public function update(JadwalPelajaran $jadwalPelajaran, array $data): JadwalPelajaran
    {
        return DB::transaction(function () use ($jadwalPelajaran, $data) {
            $jadwalPelajaran->update([
                'guru_id'           => $data['guru_id'],
                'mata_pelajaran_id' => $data['mata_pelajaran_id'],
                'kelas_id'          => $data['kelas_id'],
                'rombel_id'         => $data['rombel_id'],
                'semester_id'       => $data['semester_id'],
                'ganjil_genap'      => $data['ganjil_genap'],
                'hari'              => $data['hari'],
                'jam_mulai'         => $data['jam_mulai'],
                'jam_selesai'       => $data['jam_selesai'],
                'ruangan'           => $data['ruangan'] ?? null,
                'warna'             => $data['warna'] ?? '#1572e8',
            ]);

            return $jadwalPelajaran;
        });
    }

    /**
     * Delete a lesson schedule.
     */
    public function destroy(JadwalPelajaran $jadwalPelajaran): bool
    {
        return DB::transaction(function () use ($jadwalPelajaran) {
            return (bool) $jadwalPelajaran->delete();
        });
    }

    /**
     * Bulk delete lesson schedules.
     */
    public function bulkDestroy(array $ids): bool
    {
        if (count($ids) === 0) {
            return false;
        }

        return DB::transaction(function () use ($ids) {
            JadwalPelajaran::whereIn('id', $ids)->delete();

            return true;
        });
    }

    /**
     * Get all schedules formatted for FullCalendar.
     */
    public function getEventsForCalendar(): array
    {
        $schedules = JadwalPelajaran::with(['guru', 'mataPelajaran', 'kelas', 'rombel', 'semester'])->get();

        $daysOfWeekMap = [
            'Minggu'    => [0],
            'Senin'     => [1],
            'Selasa'    => [2],
            'Rabu'      => [3],
            'Kamis'     => [4],
            'Jumat'     => [5],
            'Sabtu'     => [6],
        ];

        $events = [];
        foreach ($schedules as $schedule) {
            $days = $daysOfWeekMap[$schedule->hari] ?? [1];

            // Format start and end times cleanly
            $startTime = date('H:i:s', strtotime($schedule->jam_mulai));
            $endTime = date('H:i:s', strtotime($schedule->jam_selesai));

            $className = $schedule->kelas->nama ?? '-';
            $rombelName = $schedule->rombel->nama ?? '-';
            $semesterName = $schedule->semester->nama ?? '-';
            $ganjilGenap = $schedule->ganjil_genap ?? '-';

            $events[] = [
                'id'                => (string) $schedule->id,
                'title'             => $schedule->mataPelajaran->nama.' ('.$className.'-'.$rombelName.') - '.$schedule->guru->nama_lengkap,
                'daysOfWeek'        => $days,
                'startTime'         => $startTime,
                'endTime'           => $endTime,
                'backgroundColor'   => $schedule->warna,
                'borderColor'       => $schedule->warna,
                'textColor'         => '#ffffff',
                'extendedProps'     => [
                    'ruangan'           => $schedule->ruangan ?? '-',
                    'guru'              => $schedule->guru->nama_lengkap,
                    'mataPelajaran'     => $schedule->mataPelajaran->nama,
                    'kelas'             => $className,
                    'rombel'            => $rombelName,
                    'semester'          => $semesterName,
                    'ganjilGenap'       => $ganjilGenap,
                    'hari'              => $schedule->hari,
                    'waktu'             => date('H:i', strtotime($schedule->jam_mulai)).' - '.date('H:i', strtotime($schedule->jam_selesai)),
                ],
            ];
        }

        return $events;
    }
}
