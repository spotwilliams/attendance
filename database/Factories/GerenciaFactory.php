<?php

namespace Database\Factories;

use Cat\Models\Gerencia;
use Illuminate\Database\Eloquent\Factories\Factory;

class GerenciaFactory extends Factory
{
    protected $model = Gerencia::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company,
        ];
    }
}
