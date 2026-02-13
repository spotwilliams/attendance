<?php

namespace Database\Factories;

use Cat\Models\Funcion;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuncionFactory extends Factory
{
    protected $model = Funcion::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word,
        ];
    }
}
