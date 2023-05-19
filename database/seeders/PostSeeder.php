<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        // Mendapatkan pengguna (user) dengan role_id 1 (Admin)
        $adminUsers = User::where('role_id', 1)->get();

        foreach (range(1, 30) as $index) {
            // Membuat berita (news) dengan data acak dan pengguna (user) yang memiliki role_id 1 (Admin)
            Post::create([
                'title' => $faker->sentence,
                'news_content' => $faker->paragraph,
                'image' => $faker->imageUrl(),
                'user_id' => $adminUsers->random()->id,
            ]);
        }
    }   
}
