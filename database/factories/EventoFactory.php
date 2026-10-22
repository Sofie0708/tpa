<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Evento>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     public function definition(): array
     {
         return [
             'titulo'      => fake()->sentence(3),
             'descricao'   => fake()->paragraph(),
             'data_evento' => fake()->dateTimeBetween('now', '+1 month'),
             'user_id'     => User::factory(),
         ];
     }
}
