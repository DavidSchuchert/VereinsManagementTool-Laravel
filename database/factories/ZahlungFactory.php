<?php

namespace Database\Factories;

use App\Models\Zahlung;
use App\Models\Zahlungsart;
use Illuminate\Database\Eloquent\Factories\Factory;

class ZahlungFactory extends Factory
{
    protected $model = Zahlung::class;

    public function definition(): array
    {
        return [
            'betrag' => fake()->randomFloat(2, 5, 500),
            'datum' => fake()->date(),
            'zahlungsart_id' => Zahlungsart::factory(),
            'typ' => fake()->randomElement(['Einnahme', 'Ausgabe']),
            'beschreibung' => fake()->sentence(),
            'rechnungsnr' => fake()->numerify('RE-####'),
        ];
    }
}
