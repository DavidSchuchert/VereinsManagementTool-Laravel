<?php

namespace Database\Factories;

use App\Models\Protokoll;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProtokollFactory extends Factory
{
    protected $model = Protokoll::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraphs(3, true),
            'user_id' => User::factory(),
        ];
    }
}
