<?php

namespace Database\Seeders;

use App\Models\Employee;
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

        $manager = Employee::create([
            'id_employee' => '001',
            'username' => 'manager',
            'fullname' => 'Manager KOPINETGO',
            'password' => bcrypt('12345678'),
            'role' => 'manager'
        ]);

        $admin = Employee::create([
            'id_employee' => '002',
            'username' => 'admin',
            'fullname' => 'Admin KOPINETGO',
            'password' => bcrypt('12345678'),
            'role' => 'admin'
        ]);

        $user = Employee::create([
            'id_employee' => '003',
            'username' => 'loremipsum',
            'fullname' => 'mas lorem ipsum',
            'position' => 'Software Engineering',
            'password' => bcrypt('12345678'),
            'role' => 'user'
        ]);
    }
}
