<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
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
                'role'          => 'admin',
            ],
            // todo guru
            [
                'name'          => 'guru',
                'email'         => 'guru@mail.com',
                'password'      => bcrypt('12345678'),
                'role'          => 'guru',
            ],
            // todo kepala sekolah  
            [
                'name'          => 'kepala sekolah',
                'email'         => 'kepala sekolah@mail.com',
                'password'      => bcrypt('12345678'),
                'role'          => 'kepala-sekolah',
            ],
            // todo siswa
            [
                'name'          => 'siswa',
                'email'         => 'siswa@mail.com',
                'password'      => bcrypt('12345678'),
                'role'          => 'siswa',
            ],
        ])->each( function ($item) {
            $user = User::create([
                'name'     => $item['name'],
                'email'    => $item['email'],
                'password' => $item['password'],
            ]);
            $user->assignRole($item['role']);
        });
    }
}
