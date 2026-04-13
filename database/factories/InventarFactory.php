<?php

namespace Database\Factories;

use App\Models\Inventar;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventarFactory extends Factory
{
    protected $model = Inventar::class;

    public function definition(): array
    {
        return [
            'artikel' => fake()->word(),
            'ean' => fake()->ean13(),
            'menge' => fake()->numberBetween(1, 100),
            'bemerkung' => fake()->sentence(),
            'lagerstandort' => fake()->word(),
            'kategorie_id' => Category::factory(),
        ];
    }
}
