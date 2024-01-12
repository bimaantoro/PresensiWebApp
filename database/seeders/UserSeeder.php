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

        $manager = User::create([
            'id' => '111',
            'username' => 'manager',
            'nama_lengkap' => 'General Manager Telkom',
            'instansi' => 'Telkom Witel Gorontalo',
            'password' => bcrypt('12345678'),
            'role' => 'manager'
        ]);

        $admin = User::create([
            'id' => '222',
            'username' => 'admin',
            'nama_lengkap' => 'Admin Telkom',
            'instansi' => 'Telkom Witel Gorontalo',
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
