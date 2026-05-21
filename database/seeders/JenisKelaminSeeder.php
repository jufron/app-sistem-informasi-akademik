<?php

namespace Database\Seeders;

use App\Models\JenisKelamin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisKelaminSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            ['nama' => 'Laki-laki', 'kode' => 'L'],
            ['nama' => 'Perempuan', 'kode' => 'P'],
        ])->each(function ($item) {
            JenisKelamin::create($item);
        });
    }
}
