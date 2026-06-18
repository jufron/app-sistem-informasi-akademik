<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AgamaSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\AppSettingSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AppSettingSeeder::class,
            RoleSeeder::class,
            AgamaSeeder::class,
            JenisKelaminSeeder::class,
            MataPelajaranSeeder::class,
            UserSeeder::class,
            GuruSeeder::class,
            SemesterSeeder::class,
            KelasSeeder::class,
            RombelSeeder::class,
            JadwalPelajaranSeeder::class,
            RuanganKelasSeeder::class,
            SiswaSeeder::class,
            AnggotaKelasSeeder::class,
        ]);
    }
}