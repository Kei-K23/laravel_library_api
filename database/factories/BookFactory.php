<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'ISBN' => fake()->isbn10(),
            'genre' => fake()->randomElement([
                'Fantasy',
                'Science Fiction',
                'Mystery',
                'Romance',
                'Thriller',
                'Non-Fiction',
                'Biography',
            ]),
            'description' => fake()->paragraph(),
        ];
    }
}
