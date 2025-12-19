<?php

namespace Database\Factories;

use Cat\Models\Contrato;
use Cat\Models\Agente;
use Cat\Models\TipoContrato;
use Cat\Models\EstadoContrato;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContratoFactory extends Factory
{
    protected $model = Contrato::class;

    public function definition()
    {
        return [
            'id_agente' => Agente::factory(),
            'id_tipo_contrato' => TipoContrato::factory(),
            'id_estado_contrato' => EstadoContrato::factory()->activo(), // Create EstadoContrato
            'monto' => 16002,
            'fecha_ingreso' => $this->faker->dateTimeBetween('-2 years', '-1 month')->format('Y-m-d'),
            'fecha_ingreso_gobierno' => $this->faker->optional()->passthrough(
                $this->faker->dateTimeBetween('-3 years', '-2 years')->format('Y-m-d')
            ),
            'ficha' => $this->faker->optional()->numerify('######'),
            'id_sial' => $this->faker->optional()->numerify('######'),
            'tipo_inscripcion' => $this->faker->optional()->word,
        ];
    }
}
