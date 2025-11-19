<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
final class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(),
            'slug' => fake()->unique()->slug(),
            'content' => fake()->paragraphs(3, true),
            'featured_image' => 'https://picsum.photos/640/480',
            'status' => fake()->randomElement(['published', 'draft']),
            'visibility' => fake()->randomElement(['public', 'private']),
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'external_link' => fake()->optional(0.3)->url(),
        ];
    }
}
