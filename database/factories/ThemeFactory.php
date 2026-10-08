<?php

namespace Database\Factories;

use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Theme>
 */
class ThemeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Cyberpunk City',
            'Golden Renaissance',
            'Studio Noir',
            'Tropical Paradise',
            'Retro Arcade',
            'Watercolor Dream',
            'Space Odyssey',
            'Vintage Hollywood',
            'Neon Nightlife',
            'Enchanted Forest',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(12),
            'prompt' => 'A portrait in the style of '.Str::lower($name).', highly detailed, cinematic lighting.',
            'thumbnail' => null,
            'is_enabled' => fake()->boolean(80),
        ];
    }
}
