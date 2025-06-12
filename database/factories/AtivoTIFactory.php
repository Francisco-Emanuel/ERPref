<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AtivoTI>
 */
class AtivoTIFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identificacao' => fake()->unique()->creditCardNumber(),
            'descricao_problema' => fake()->paragraph(),
            'tipo_ativo' => fake()->word,
            'setor' => fake()->streetName(),
            'usuario_responsavel' => fake()->name(),
            'status' => fake()->boolean()
        ];
    }
}
