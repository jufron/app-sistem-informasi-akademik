<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RuanganKelas;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\Semester;
use App\Models\Guru;

class RuanganKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelas1 = Kelas::where('nama', 'Kelas 1')->first();
        $kelas2 = Kelas::where('nama', 'Kelas 2')->first();
        
        $rombelA = Rombel::where('nama', 'A')->first();
        $rombelB = Rombel::where('nama', 'B')->first();
        
        $semester1 = Semester::where('nama', 'Semester 1')->first();
        $semester2 = Semester::where('nama', 'Semester 2')->first();
        
        $gurus = Guru::limit(2)->get();
        if ($gurus->count() < 2) {
            return;
        }

        // Seed Ruangan 1
        RuanganKelas::create([
            'kelas_id' => $kelas1->id,
            'rombel_id' => $rombelA->id,
            'semester_id' => $semester1->id,
            'guru_id' => $gurus[0]->id,
            'tahun_angkatan' => '2023',
            'tahun_ajaran' => '2023/2024',
            'aktif' => true,
        ]);

        // Seed Ruangan 2
        RuanganKelas::create([
            'kelas_id' => $kelas2->id,
            'rombel_id' => $rombelB->id,
            'semester_id' => $semester2->id,
            'guru_id' => $gurus[1]->id,
            'tahun_angkatan' => '2023',
            'tahun_ajaran' => '2023/2024',
            'aktif' => true,
        ]);
    }
}

