<?php

namespace Database\Factories;

use Cat\Models\Horario;
use Illuminate\Database\Eloquent\Factories\Factory;

class HorarioFactory extends Factory
{
    protected $model = Horario::class;

    public function definition(): array
    {
        return [
            'hora_entrada' => $this->faker->time('H:i:s'),
            'hora_salida' => $this->faker->time('H:i:s'),
        ];
    }
}
