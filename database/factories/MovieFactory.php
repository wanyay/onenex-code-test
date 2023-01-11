<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name,
            'summary' => $this->faker->sentence(50),
            'cover_image' =>  '',
            'genres' => $this->faker->randomElement(['Action', 'Adventure', 'Drama', 'Science fiction']),
            'author' => $this->faker->name,
            'tags' => $this->faker->randomElement(['action', 'adventure', 'drama', 'sci-fi']),
            'imdb_rate' => $this->faker->randomDigit,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
