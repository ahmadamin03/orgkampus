<?php

namespace Database\Factories;

use App\Models\Tugas;
use Illuminate\Database\Eloquent\Factories\Factory;

class TugasFactory extends Factory
{
    protected $model = Tugas::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed']),
            'deadline' => fake()->date(),
        ];
    }
}
