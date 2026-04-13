<?php

namespace Database\Factories;

use App\Models\Zahlungsart;
use Illuminate\Database\Eloquent\Factories\Factory;

class ZahlungsartFactory extends Factory
{
    protected $model = Zahlungsart::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
        ];
    }
}
