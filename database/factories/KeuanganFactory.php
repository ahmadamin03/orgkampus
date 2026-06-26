<?php

namespace Database\Factories;

use App\Models\Keuangan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeuanganFactory extends Factory
{
    protected $model = Keuangan::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'type' => fake()->randomElement(['pemasukan', 'pengeluaran']),
            'amount' => fake()->numberBetween(10000, 10000000),
            'description' => fake()->sentence(),
            'date' => fake()->date(),
        ];
    }
}
