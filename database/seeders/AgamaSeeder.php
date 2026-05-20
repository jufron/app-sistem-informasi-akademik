<?php

namespace Database\Seeders;

use App\Models\Agama;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        collect([
            ['nama'      => 'Islam'],
            ['nama'      => 'Kristen Protestan'],
            ['nama'      => 'Katolik'],
            ['nama'      => 'Hindu'],
            ['nama'      => 'Buddha'],
            ['nama'      => 'Konghucu'],
        ])->each( function ($item) {
            Agama::create($item);
        });
    }
}

