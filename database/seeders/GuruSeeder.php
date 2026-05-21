<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Agama;
use App\Models\JenisKelamin;
use App\Models\MataPelajaran;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch structural items
        $lakiLaki = JenisKelamin::where('kode', 'L')->first();
        $perempuan = JenisKelamin::where('kode', 'P')->first();
        $katolik = Agama::where('nama', 'Katolik')->first();

        // Fetch subjects
        $matematika = MataPelajaran::where('nama', 'Matematika')->first();
        $ipas = MataPelajaran::where('nama', 'Ilmu Pengetahuan Alam dan Sosial (IPAS)')->first();
        $inggris = MataPelajaran::where('nama', 'Bahasa Inggris')->first();
        $indonesia = MataPelajaran::where('nama', 'Bahasa Indonesia')->first();
        $agamaMapel = MataPelajaran::where('nama', 'Pendidikan Agama dan Budi Pekerti')->first();

        DB::transaction(function () use ($lakiLaki, $perempuan, $katolik, $matematika, $ipas, $inggris, $indonesia, $agamaMapel) {
            
            // 1. Antonius Budi, S.Pd
            $user1 = User::create([
                'name'     => 'Antonius Budi',
                'email'    => 'antonius@mail.com',
                'password' => bcrypt('12345678'),
            ]);
            $user1->assignRole('guru');

            $guru1 = Guru::create([
                'user_id'          => $user1->id,
                'nip'              => '198503122010011002',
                'nama_lengkap'     => 'Antonius Budi, S.Pd',
                'nama_panggilan'   => 'Anton',
                'jenis_kelamin_id' => $lakiLaki->id,
                'agama_id'         => $katolik->id,
                'tempat_lahir'     => 'Weetabula',
                'tanggal_lahir'    => '1985-03-12',
                'telepon'          => '081234567890',
                'alamat'           => 'Jl. Melati No. 12, Weetabula',
                'tipe'             => 'Wali Kelas',
                'foto'             => null,
                'status'           => 'Aktif',
            ]);
            
            $guru1->mataPelajaran()->attach([
                $matematika->id,
                $ipas->id
            ]);

            // 2. Maria Yosefina, S.Pd
            $user2 = User::create([
                'name'     => 'Maria Yosefina',
                'email'    => 'maria@mail.com',
                'password' => bcrypt('12345678'),
            ]);
            $user2->assignRole('guru');

            $guru2 = Guru::create([
                'user_id'          => $user2->id,
                'nip'              => '199008242015022001',
                'nama_lengkap'     => 'Maria Yosefina, S.Pd',
                'nama_panggilan'   => 'Maria',
                'jenis_kelamin_id' => $perempuan->id,
                'agama_id'         => $katolik->id,
                'tempat_lahir'     => 'Tambolaka',
                'tanggal_lahir'    => '1990-08-24',
                'telepon'          => '081234567891',
                'alamat'           => 'Jl. Mawar No. 45, Tambolaka',
                'tipe'             => 'Bukan Wali Kelas',
                'foto'             => null,
                'status'           => 'Aktif',
            ]);
            
            $guru2->mataPelajaran()->attach([
                $inggris->id,
                $indonesia->id
            ]);

            // 3. Yohanes Don Bosco
            $user3 = User::create([
                'name'     => 'Yohanes Don Bosco',
                'email'    => 'yohanes@mail.com',
                'password' => bcrypt('12345678'),
            ]);
            $user3->assignRole('kepala-sekolah');

            $guru3 = Guru::create([
                'user_id'          => $user3->id,
                'nip'              => '198801152012011003',
                'nama_lengkap'     => 'Yohanes Don Bosco',
                'nama_panggilan'   => 'Yohan',
                'jenis_kelamin_id' => $lakiLaki->id,
                'agama_id'         => $katolik->id,
                'tempat_lahir'     => 'Waingapu',
                'tanggal_lahir'    => '1988-01-15',
                'telepon'          => '081234567892',
                'alamat'           => 'Jl. Kenanga No. 8, Waingapu',
                'tipe'             => 'Kepala Sekolah',
                'foto'             => null,
                'status'           => 'Aktif',
            ]);
            
            $guru3->mataPelajaran()->attach([
                $agamaMapel->id
            ]);
        });
    }
}
