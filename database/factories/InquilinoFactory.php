<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inquilino>
 */
class InquilinoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $digits = $this->faker->numerify('########-'); // 8 dígitos
        $letter = strtoupper($this->faker->randomLetter()); // 1 letra mayúscula
        return [
            'nombres' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->phoneNumber(),
            'fecha_nacimiento' => fake()->date(),
            'dni' => $digits . $letter,
        ];
    }
}
