<?php

namespace Database\Factories;

use Cat\Models\Cargo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CargoFactory extends Factory
{
    protected $model = Cargo::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->jobTitle,
        ];
    }
}
