<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'key' => Str::slug($this->faker->unique()->words(2, true)),
            'tag' => $this->faker->randomElement(['web', 'mobile', 'desktop']),
            'name' => ['en' => $this->faker->words(2, true)],
            'description' => ['en' => $this->faker->sentence()],
        ];
    }
}
