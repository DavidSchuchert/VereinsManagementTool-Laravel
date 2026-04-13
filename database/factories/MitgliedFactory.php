<?php

namespace Database\Factories;

use App\Models\Mitglied;
use App\Models\Rangart;
use Illuminate\Database\Eloquent\Factories\Factory;

class MitgliedFactory extends Factory
{
    protected $model = Mitglied::class;

    public function definition(): array
    {
        return [
            'mitgliedsnummer' => fake()->unique()->numerify('M-#####'),
            'vorname' => fake()->firstName(),
            'nachname' => fake()->lastName(),
            'geburtsdatum' => fake()->date('Y-m-d', '-18 years'),
            'plz' => (int) fake()->postcode(),
            'ort' => fake()->city(),
            'strasse' => fake()->streetName(),
            'hausnummer' => fake()->buildingNumber(),
            'telefon' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'eintrittsdatum' => fake()->date(),
            'austrittsdatum' => null,
            'rang_id' => \App\Models\Rangart::inRandomOrder()->first()->id ?? 1,
        ];
    }
}
