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

        // These are the only themes the guest photobooth currently offers.
        // Events, sessions and generated images are created for real as guests use the booth.
        $themes = [
            ['slug' => 'graduation', 'name' => 'Graduation', 'description' => 'Professional graduation portrait'],
            ['slug' => 'spiderman', 'name' => 'Spider-Man', 'description' => 'Cinematic superhero experience'],
            ['slug' => 'mafia', 'name' => 'Mafia', 'description' => 'Classic luxury crime-film aesthetic'],
        ];

        foreach ($themes as $theme) {
            Theme::firstOrCreate(
                ['slug' => $theme['slug']],
                ['name' => $theme['name'], 'description' => $theme['description'], 'is_enabled' => true],
            );
        }
    }
}
