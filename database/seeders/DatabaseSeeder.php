<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $users = User::factory(10)->create();

        $allUsers = $users->push($testUser);

        $allUsers->each(function ($user) {
            Article::factory(rand(2, 5))->create([
                'user_id' => $user->id,
            ]);
        });

        Article::all()->each(function ($article) use ($allUsers) {
            Comment::factory(rand(2, 5))->create([
                'user_id' => $allUsers->random()->id,
                'article_id' => $article->id,
            ]);
        });
    }
}
