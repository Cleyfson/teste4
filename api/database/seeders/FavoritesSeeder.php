<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class FavoritesSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        if (!$user) {
            $this->command->error('User not found!');
            return;
        }

        $favorites = [
            [
                'user_id' => $user->id,
                'movie_id' => 125249,
                'movie_title' => 'O Morcego (Batman)',
                'original_title' => 'Batman',
                'overview' => 'Em Gotham City, Batman (Lewis Wilson) luta contra Dr. Daka...',
                'poster_path' => '/AvzD3mrtokIzZOiV6zAG7geIo6F.jpg',
                'release_date' => '1943-07-16',
                'genre_ids' => json_encode([28, 12, 80, 878, 53, 10752]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user->id,
                'movie_id' => 268,
                'movie_title' => 'Batman',
                'original_title' => 'Batman',
                'overview' => 'Em Gotham City o milionário Bruce Wayne...',
                'poster_path' => '/1aadn0aD7h1VKq4yap2uKl7cTSL.jpg',
                'release_date' => '1989-06-21',
                'genre_ids' => json_encode([14, 28, 80]),
                'created_at' => now(),
                'updated_at' => now(),
            ],            [
              'user_id' => $user->id,
              'movie_id' => 497,
              'movie_title' => 'À Espera de um Milagre',
              'original_title' => 'The Green Mile',
              'overview' => 'Milagres acontecem em lugares inesperados...',
              'poster_path' => '/14hEqW67IiHlKpzKMLUXyktzZIV.jpg',
              'release_date' => '1999-12-10',
              'genre_ids' => json_encode([14, 18, 80]),
              'created_at' => now(),
              'updated_at' => now(),
          ],
        ];

        DB::table('favorites')->insert($favorites);
    }
}
