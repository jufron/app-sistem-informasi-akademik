<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AnggotaKelas;
use App\Models\Siswa;
use App\Models\RuanganKelas;

class AnggotaKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = Siswa::all();
        $ruangans = RuanganKelas::all();

        if ($siswas->count() === 0 || $ruangans->count() === 0) {
            return;
        }

        // Assign first two students to the first classroom
        foreach ($siswas->take(2) as $siswa) {
            AnggotaKelas::create([
                'siswa_id' => $siswa->id,
                'ruangan_kelas_id' => $ruangans[0]->id,
                'tanggal_masuk' => '2023-07-17',
                'status' => 'Aktif',
                'keterangan' => 'Siswa Baru',
            ]);
        }

        // Assign the other two students to the second classroom
        foreach ($siswas->skip(2)->take(2) as $siswa) {
            AnggotaKelas::create([
                'siswa_id' => $siswa->id,
                'ruangan_kelas_id' => $ruangans[1]->id,
                'tanggal_masuk' => '2023-07-17',
                'status' => 'Aktif',
                'keterangan' => 'Siswa Baru',
            ]);
        }
    }
}
