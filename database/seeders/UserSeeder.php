<?php

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
        //
        // $admin = User::create([
        //     'username' => 'adminkopinetgtlo',
        //     'password' => bcrypt('12345678'),
        // ]);

        // $admin->assignRole('admin');

        // $user = User::create([
        //     'username' => 'johndoe',
        //     'password' => bcrypt('12345678'),
        // ]);

        // $user->assignRole('user');

        $admin = User::create([
            'id' => 'TLKM01',
            'username' => 'admin',
            'nama_lengkap' => 'Admin Presensi Telkom',
            'password' => bcrypt('12345678'),
            'role' => 'admin'
        ]);

        $user = User::create([
            'id' => '531420054',
            'username' => 'bimantoro',
            'nama_lengkap' => 'Muhammad Amirul Bimantoro',
            'instansi' => 'Universitas Negeri Gorontalo',
            'password' => bcrypt('12345678'),
            'role' => 'student'
        ]);
    }
}
