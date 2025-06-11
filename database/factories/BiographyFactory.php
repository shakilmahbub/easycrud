<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Biography;

class BiographyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Biography::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(18, 70),
            'biography' => $this->faker->paragraph(3),
            'sport' => $this->faker->randomElement(['Soccer', 'Basketball', 'Tennis', 'Swimming', 'Athletics']),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'colors' => implode(', ', $this->faker->randomElements(['Red', 'Green', 'Blue', 'Yellow', 'Black', 'White'], $this->faker->numberBetween(1, 3))),
            'is_retired' => $this->faker->boolean(25), // 25% chance of being retired
            'photo' => null, // Default to null, can be overridden in tests if a photo is uploaded
            // 'photo' => 'photos/' . Str::random(10) . '.jpg', // Example if you wanted to always generate a fake path
            'range' => $this->faker->numberBetween(1, 10) . '-' . $this->faker->numberBetween(11, 20),
            'month' => $this->faker->monthName(),
        ];
    }
}
