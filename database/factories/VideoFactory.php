<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Video>
 */
final class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'embed_code' => $this->generateEmbedCode(),
        ];
    }

    /**
     * Generate a realistic video embed code.
     */
    private function generateEmbedCode(): string
    {
        $platforms = ['youtube', 'vimeo'];
        $platform = fake()->randomElement($platforms);

        return match ($platform) {
            'youtube' => sprintf(
                '<iframe width="560" height="315" src="https://www.youtube.com/embed/%s" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
                fake()->regexify('[A-Za-z0-9_-]{11}')
            ),
            'vimeo' => sprintf(
                '<iframe src="https://player.vimeo.com/video/%s" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>',
                fake()->numberBetween(100000000, 999999999)
            ),
        };
    }
}
