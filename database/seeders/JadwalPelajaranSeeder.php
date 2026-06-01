<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\JadwalPelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch teachers
        $anton = Guru::where('nama_lengkap', 'like', '%Antonius Budi%')->first();
        $maria = Guru::where('nama_lengkap', 'like', '%Maria Yosefina%')->first();
        $yohan = Guru::where('nama_lengkap', 'like', '%Yohanes Don Bosco%')->first();

        // Fetch subjects
        $matematika = MataPelajaran::where('nama', 'like', '%Matematika%')->first();
        $ipas = MataPelajaran::where('nama', 'like', '%IPAS%')->orWhere('nama', 'like', '%Ilmu Pengetahuan Alam%')->first();
        $inggris = MataPelajaran::where('nama', 'like', '%Inggris%')->first();
        $indonesia = MataPelajaran::where('nama', 'like', '%Indonesia%')->first();
        $agama = MataPelajaran::where('nama', 'like', '%Agama%')->first();

        // Fetch Kelas, Rombel, and Semester
        $kelas1 = \App\Models\Kelas::where('nama', 'like', '%Kelas 1%')->first() ?: \App\Models\Kelas::first();
        $kelas2 = \App\Models\Kelas::where('nama', 'like', '%Kelas 2%')->first() ?: \App\Models\Kelas::first();
        $rombelA = \App\Models\Rombel::where('nama', 'A')->first() ?: \App\Models\Rombel::first();
        $rombelB = \App\Models\Rombel::where('nama', 'B')->first() ?: \App\Models\Rombel::first();
        $sem1 = \App\Models\Semester::where('nama', 'like', '%Semester 1%')->first() ?: \App\Models\Semester::first();
        $sem2 = \App\Models\Semester::where('nama', 'like', '%Semester 2%')->first() ?: \App\Models\Semester::first();

        // Standard fallback just in case
        if (!$anton || !$maria || !$yohan || !$matematika || !$ipas || !$inggris || !$indonesia || !$agama || !$kelas1 || !$kelas2 || !$rombelA || !$rombelB || !$sem1 || !$sem2) {
            return;
        }

        DB::transaction(function () use ($anton, $maria, $yohan, $matematika, $ipas, $inggris, $indonesia, $agama, $kelas1, $kelas2, $rombelA, $rombelB, $sem1, $sem2) {
            $rosters = [
                // Senin (Monday)
                [
                    'guru_id'           => $anton->id,
                    'mata_pelajaran_id' => $matematika->id,
                    'kelas_id'          => $kelas1->id,
                    'rombel_id'         => $rombelA->id,
                    'semester_id'       => $sem1->id,
                    'ganjil_genap'      => 'Ganjil',
                    'hari'              => 'Senin',
                    'jam_mulai'         => '07:30',
                    'jam_selesai'       => '09:00',
                    'ruangan'           => 'Kelas 1-A',
                    'warna'             => '#1572e8', // Cobalt Blue
                ],
                [
                    'guru_id'           => $maria->id,
                    'mata_pelajaran_id' => $inggris->id,
                    'kelas_id'          => $kelas1->id,
                    'rombel_id'         => $rombelA->id,
                    'semester_id'       => $sem1->id,
                    'ganjil_genap'      => 'Ganjil',
                    'hari'              => 'Senin',
                    'jam_mulai'         => '09:15',
                    'jam_selesai'       => '10:45',
                    'ruangan'           => 'Kelas 1-A',
                    'warna'             => '#6610f2', // Royal Purple
                ],
                // Selasa (Tuesday)
                [
                    'guru_id'           => $anton->id,
                    'mata_pelajaran_id' => $ipas->id,
                    'kelas_id'          => $kelas1->id,
                    'rombel_id'         => $rombelA->id,
                    'semester_id'       => $sem1->id,
                    'ganjil_genap'      => 'Ganjil',
                    'hari'              => 'Selasa',
                    'jam_mulai'         => '07:30',
                    'jam_selesai'       => '09:00',
                    'ruangan'           => 'Kelas 1-A',
                    'warna'             => '#198754', // Emerald Green
                ],
                [
                    'guru_id'           => $maria->id,
                    'mata_pelajaran_id' => $indonesia->id,
                    'kelas_id'          => $kelas2->id,
                    'rombel_id'         => $rombelB->id,
                    'semester_id'       => $sem2->id,
                    'ganjil_genap'      => 'Genap',
                    'hari'              => 'Selasa',
                    'jam_mulai'         => '09:15',
                    'jam_selesai'       => '10:45',
                    'ruangan'           => 'Kelas 2-B',
                    'warna'             => '#fd7e14', // Sunset Orange
                ],
                // Rabu (Wednesday)
                [
                    'guru_id'           => $yohan->id,
                    'mata_pelajaran_id' => $agama->id,
                    'kelas_id'          => $kelas1->id,
                    'rombel_id'         => $rombelA->id,
                    'semester_id'       => $sem1->id,
                    'ganjil_genap'      => 'Ganjil',
                    'hari'              => 'Rabu',
                    'jam_mulai'         => '08:00',
                    'jam_selesai'       => '09:30',
                    'ruangan'           => 'Kelas 1-A',
                    'warna'             => '#dc3545', // Crimson Red
                ],
                [
                    'guru_id'           => $anton->id,
                    'mata_pelajaran_id' => $matematika->id,
                    'kelas_id'          => $kelas2->id,
                    'rombel_id'         => $rombelB->id,
                    'semester_id'       => $sem2->id,
                    'ganjil_genap'      => 'Genap',
                    'hari'              => 'Rabu',
                    'jam_mulai'         => '10:00',
                    'jam_selesai'       => '11:30',
                    'ruangan'           => 'Kelas 2-B',
                    'warna'             => '#1572e8', // Cobalt Blue
                ],
                // Kamis (Thursday)
                [
                    'guru_id'           => $maria->id,
                    'mata_pelajaran_id' => $inggris->id,
                    'kelas_id'          => $kelas2->id,
                    'rombel_id'         => $rombelB->id,
                    'semester_id'       => $sem2->id,
                    'ganjil_genap'      => 'Genap',
                    'hari'              => 'Kamis',
                    'jam_mulai'         => '07:30',
                    'jam_selesai'       => '09:00',
                    'ruangan'           => 'Kelas 2-B',
                    'warna'             => '#6610f2', // Royal Purple
                ],
                [
                    'guru_id'           => $anton->id,
                    'mata_pelajaran_id' => $ipas->id,
                    'kelas_id'          => $kelas1->id,
                    'rombel_id'         => $rombelA->id,
                    'semester_id'       => $sem1->id,
                    'ganjil_genap'      => 'Ganjil',
                    'hari'              => 'Kamis',
                    'jam_mulai'         => '09:15',
                    'jam_selesai'       => '10:45',
                    'ruangan'           => 'Laboratorium IPA',
                    'warna'             => '#198754', // Emerald Green
                ],
                // Jumat (Friday)
                [
                    'guru_id'           => $maria->id,
                    'mata_pelajaran_id' => $indonesia->id,
                    'kelas_id'          => $kelas1->id,
                    'rombel_id'         => $rombelA->id,
                    'semester_id'       => $sem1->id,
                    'ganjil_genap'      => 'Ganjil',
                    'hari'              => 'Jumat',
                    'jam_mulai'         => '07:30',
                    'jam_selesai'       => '09:00',
                    'ruangan'           => 'Kelas 1-A',
                    'warna'             => '#fd7e14', // Sunset Orange
                ],
                [
                    'guru_id'           => $yohan->id,
                    'mata_pelajaran_id' => $agama->id,
                    'kelas_id'          => $kelas2->id,
                    'rombel_id'         => $rombelB->id,
                    'semester_id'       => $sem2->id,
                    'ganjil_genap'      => 'Genap',
                    'hari'              => 'Jumat',
                    'jam_mulai'         => '09:15',
                    'jam_selesai'       => '10:45',
                    'ruangan'           => 'Kelas 2-B',
                    'warna'             => '#dc3545', // Crimson Red
                ],
            ];

            foreach ($rosters as $roster) {
                JadwalPelajaran::create($roster);
            }
        });
    }
}

