<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\GeneratedImage;
use App\Models\PhotoSession;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GeneratedImage>
 */
class GeneratedImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['completed', 'completed', 'completed', 'completed', 'failed']);

        return [
            'photo_session_id' => PhotoSession::factory(),
            'event_id' => Event::factory(),
            'theme_id' => Theme::factory(),
            'original_image_path' => null,
            'generated_image_path' => $status === 'completed' ? null : null,
            'status' => $status,
            'error_message' => $status === 'failed' ? fake()->randomElement([
                'AI provider timed out',
                'Content policy violation detected',
                'Upstream API rate limit exceeded',
            ]) : null,
            'rating' => $status === 'completed' && fake()->boolean(60) ? fake()->numberBetween(1, 5) : null,
            'feedback_comment' => $status === 'completed' && fake()->boolean(30) ? fake()->sentence(8) : null,
        ];
    }
}
