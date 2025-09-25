<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Propiedad>
 */
class PropiedadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo' => fake()->randomElement(['casa', 'departamento', 'local comercial', 'terreno']),
            'direccion' => fake()->address(),
            'precio' => fake()->randomFloat(2, 100000, 1000000),
            'descripcion' => fake()->text(),
            'estado' => fake()->randomElement(['disponible', 'alquilado', 'mantenimiento']),
        ];
    }
}
