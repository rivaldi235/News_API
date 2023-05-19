<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'name' => 'Admin',
            'email'=>'admin@mail.com',
            'password' => bcrypt('1234'),
            'role_id' => '1'
        ],
        [
            'name' => 'User',
            'email'=>'user@mail.com',
            'password' => bcrypt('1234'),
            'role_id' => '2'
        ]);
    }
}
