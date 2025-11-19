<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Seo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Seo>
 */
final class SeoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'meta_title' => fake()->sentence(),
            'meta_description' => fake()->paragraph(),
            'keywords' => fake()->words(5),
            'og_title' => fake()->sentence(),
            'og_description' => fake()->paragraph(),
            'og_image' => fake()->imageUrl(1200, 630),
            'twitter_card' => fake()->randomElement(['summary', 'summary_large_image', 'app', 'player']),
            'twitter_title' => fake()->sentence(),
            'twitter_description' => fake()->paragraph(),
            'twitter_image' => fake()->imageUrl(1200, 630),
            'twitter_site' => '@'.fake()->userName(),
            'twitter_creator' => '@'.fake()->userName(),
            'canonical_url' => fake()->url(),
            'no_index' => fake()->boolean(10),
            'no_follow' => fake()->boolean(10),
        ];
    }
}
