<?php

namespace Database\Factories;

use App\Models\Proker;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProkerFactory extends Factory
{
    protected $model = Proker::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'budget' => fake()->numberBetween(100000, 10000000),
            'status' => fake()->randomElement(['Rencana', 'Berjalan', 'Selesai']),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
        ];
    }
}
