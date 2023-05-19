<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        // Mendapatkan pengguna (user) dengan role_id 2 (User)
        $users = User::where('role_id', 2)->get();

        // Mendapatkan semua postingan (posts)
        $posts = Post::all();

        foreach (range(1, 30) as $index) {
            // Membuat komentar (comment) dengan data acak dan pengguna (user) yang memiliki role_id 2 (User)
            Comment::create([
                'post_id' => $posts->random()->id,
                'user_id' => $users->random()->id,
                'comment' => $faker->paragraph,
            ]);
        }
    }
}
