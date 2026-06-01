<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\User;
use App\Models\JenisKelamin;
use App\Models\Agama;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jkLaki = JenisKelamin::where('nama', 'Laki-laki')->first();
        $jkPerempuan = JenisKelamin::where('nama', 'Perempuan')->first();
        $agamaIslam = Agama::where('nama', 'Islam')->first();
        $agamaKristen = Agama::where('nama', 'Kristen Protestan')->first();


        $studentsData = [
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@siswa.com',
                'nisn' => '0101234567',
                'nis' => '20230001',
                'jk' => $jkLaki,
                'agama' => $agamaIslam,
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2012-05-15',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.aminah@siswa.com',
                'nisn' => '0101234568',
                'nis' => '20230002',
                'jk' => $jkPerempuan,
                'agama' => $agamaIslam,
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2012-08-20',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Diponegoro No. 25, Bandung',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@siswa.com',
                'nisn' => '0101234569',
                'nis' => '20230003',
                'jk' => $jkLaki,
                'agama' => $agamaIslam,
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2012-03-10',
                'telepon' => '081234567892',
                'alamat' => 'Jl. Pahlawan No. 5, Surabaya',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@siswa.com',
                'nisn' => '0101234570',
                'nis' => '20230004',
                'jk' => $jkPerempuan,
                'agama' => $agamaKristen,
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => '2012-11-25',
                'telepon' => '081234567893',
                'alamat' => 'Jl. Sudirman No. 50, Medan',
            ],
        ];

        foreach ($studentsData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('12345678'),
            ]);

            $user->assignRole('siswa');

            Siswa::create([
                'user_id' => $user->id,
                'nisn' => $data['nisn'],
                'nis' => $data['nis'],
                'nama_lengkap' => $data['name'],
                'nama_panggilan' => explode(' ', $data['name'])[0],
                'jenis_kelamin_id' => $data['jk']->id,
                'agama_id' => $data['agama']->id,
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'telepon' => $data['telepon'],
                'alamat' => $data['alamat'],
                'status' => 'Aktif',
            ]);
        }
    }
}
