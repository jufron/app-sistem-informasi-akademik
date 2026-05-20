<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            // todo admin
            [
                'name'          => 'admin',
                'email'         => 'admin@mail.com',
                'password'      => bcrypt('12345678'),
            ],
            // todo guru
            [
                'name'          => 'guru',
                'email'         => 'guru@mail.com',
                'password'      => bcrypt('12345678'),
            ],
            // todo kepala sekolah  
            [
                'name'          => 'kepala sekolah',
                'email'         => 'kepala sekolah@mail.com',
                'password'      => bcrypt('12345678'),
            ],
            // todo siswa
            [
                'name'          => 'siswa',
                'email'         => 'siswa@mail.com',
                'password'      => bcrypt('12345678'),
            ],
        ])->each( function ($item) {
            User::create($item);
        });
    }
}
