<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Neon Nights Gala',
            'Startup Summit '.fake()->year(),
            'Golden Hour Wedding',
            'Future Forward Conference',
            'Studio 54 Reunion Party',
            'Product Launch: Nova',
        ]);

        $start = fake()->dateTimeBetween('-1 month', '+2 months');

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(100, 999),
            'description' => fake()->sentence(16),
            'cover_image' => null,
            'location' => fake()->city(),
            'start_date' => $start,
            'end_date' => (clone $start)->modify('+4 hours'),
            'status' => fake()->randomElement(['active', 'active', 'active', 'draft', 'completed']),
        ];
    }
}
