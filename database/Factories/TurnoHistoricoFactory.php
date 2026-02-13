<?php

namespace Database\Factories;

use Cat\Models\TurnoHistorico;
use Cat\Models\Operativo;
use Cat\Models\Turno;
use Illuminate\Database\Eloquent\Factories\Factory;

class TurnoHistoricoFactory extends Factory
{
    protected $model = TurnoHistorico::class;

    public function definition(): array
    {
        return [
            'id_operativo' => Operativo::factory(),
            'id_turno' => Turno::factory(),
            'fecha_inicio' => $this->faker->dateTimeBetween('-2 years', '-1 year')->format('Y-m-d'),
            'fecha_fin' => $this->faker->optional()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}
