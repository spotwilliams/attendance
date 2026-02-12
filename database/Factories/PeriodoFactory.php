<?php

namespace Database\Factories;

use Cat\Models\Periodo;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodoFactory extends Factory
{
    protected $model = Periodo::class;

    public function definition()
    {
        $fechaComienzo = $this->faker->dateTimeBetween('-60 days', 'now');
        $fechaFin = (clone $fechaComienzo)->modify('+30 days');

        return [
            'fecha_comienzo' => $fechaComienzo->format('Y-m-d'),
            'fecha_fin' => $fechaFin->format('Y-m-d'),
            'cant_dias' => 30,
        ];
    }
}
