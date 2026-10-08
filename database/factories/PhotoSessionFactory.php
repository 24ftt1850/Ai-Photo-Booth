<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\PhotoSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PhotoSession>
 */
class PhotoSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $started = fake()->dateTimeBetween('-1 month', 'now');

        return [
            'event_id' => Event::factory(),
            'guest_name' => fake()->firstName(),
            'status' => fake()->randomElement(['active', 'completed', 'completed', 'abandoned']),
            'started_at' => $started,
            'ended_at' => (clone $started)->modify('+'.fake()->numberBetween(2, 15).' minutes'),
        ];
    }
}
