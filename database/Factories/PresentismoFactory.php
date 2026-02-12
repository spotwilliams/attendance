<?php

namespace Database\Factories;

use Cat\Models\Presentismo;
use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Models\TipoPresentismo;
use Cat\Models\Turno;
use Cat\Models\TipoContrato;
use Illuminate\Database\Eloquent\Factories\Factory;

class PresentismoFactory extends Factory
{
    protected $model = Presentismo::class;

    public function definition()
    {
        return [
            'id_agente' => Agente::factory(),
            'id_periodo' => Periodo::factory(),
            'id_tipo_presentismo' => TipoPresentismo::factory(),
            'id_turno' => Turno::factory(),
            'id_tipo_contrato' => TipoContrato::factory(),
            'fecha' => $this->faker->dateTimeBetween('-30 days', 'now')->format('Y-m-d'),
            'injustificado' => $this->faker->boolean(20),
        ];
    }
}
