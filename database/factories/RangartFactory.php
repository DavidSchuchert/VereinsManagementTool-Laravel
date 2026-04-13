<?php

namespace Database\Factories;

use App\Models\Rangart;
use Illuminate\Database\Eloquent\Factories\Factory;

class RangartFactory extends Factory
{
    protected $model = Rangart::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
        ];
    }
}
