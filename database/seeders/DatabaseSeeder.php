<?php

namespace Database\Seeders;

use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => Hash::make('password')],
        );

        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'role' => 'admin', 'password' => Hash::make('password')],
        );

        // Starter themes for the guest photobooth. Admins can add, edit,
        // enable/disable, or remove themes from the admin panel — the
        // guest theme-selection page reads directly from this table.
        $themes = [
            [
                'slug' => 'graduation',
                'name' => 'Graduation',
                'description' => 'Professional graduation portrait',
                'prompt' => "Transform the person's photo into a professional graduation portrait. Preserve the person's facial identity, facial features, hairstyle, body proportions and overall appearance. Place the person in an elegant university graduation environment, wearing appropriate graduation attire, with professional photography and cinematic lighting.",
            ],
            [
                'slug' => 'spiderman',
                'name' => 'Spider-Man',
                'description' => 'Cinematic superhero experience',
                'prompt' => "Transform the person's photo into a cinematic superhero scene inspired by Spider-Man. Preserve the person's facial identity, facial features, hairstyle, body proportions and overall appearance. Place the person in a dramatic modern city environment with red and blue superhero-inspired aesthetics, dynamic cinematic lighting and professional movie-poster photography.",
            ],
            [
                'slug' => 'mafia',
                'name' => 'Mafia',
                'description' => 'Classic luxury crime-film aesthetic',
                'prompt' => "Transform the person's photo into a cinematic classic mafia-inspired portrait. Preserve the person's facial identity, facial features, hairstyle, body proportions and overall appearance. Place the person in an elegant dark suit inside a luxurious vintage environment with dramatic shadows, warm cinematic lighting and sophisticated professional photography.",
            ],
        ];

        foreach ($themes as $theme) {
            Theme::firstOrCreate(
                ['slug' => $theme['slug']],
                [
                    'name' => $theme['name'],
                    'description' => $theme['description'],
                    'prompt' => $theme['prompt'],
                    'is_enabled' => true,
                ],
            );
        }
    }
}
