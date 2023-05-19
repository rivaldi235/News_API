<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat role admin
        $adminRole = Role::updateOrCreate(['id' => 1], ['name' => 'Admin']);

        // Membuat user admin
        User::updateOrCreate([
            'email' => 'admin@mail.com',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('1234'),
            'role_id' => $adminRole->id
        ]);

        // Membuat role user
        $userRole = Role::updateOrCreate(['id' => 2], ['name' => 'User']);

        // Membuat user biasa
        User::updateOrCreate([
            'email' => 'user@mail.com',
        ], [
            'name' => 'User',
            'password' => bcrypt('1234'),
            'role_id' => $userRole->id
        ]);

        // Membuat 9 user tambahan
        for ($i = 1; $i <= 9; $i++) {
            User::factory()->create([
                'role_id' => $userRole->id
            ]);
        }
    }

}

