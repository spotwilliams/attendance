<?php

namespace Database\Factories;

use Cat\Models\Agente;
use Cat\Models\ContratoHistorico;
use Cat\Models\Contrato;
use Cat\Models\EstadoContrato;
use Cat\Models\TipoContrato;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContratoHistoricoFactory extends Factory
{
    protected $model = ContratoHistorico::class;

    public function definition(): array
    {
        return [
            'id_agente' => Agente::factory(),
            'id_tipo_contrato' => TipoContrato::factory(),
            'id_estado_contrato' => EstadoContrato::factory()->activo(), // Create EstadoContrato
            'fecha_ingreso' => now()->subYear(),
            'fecha_fin' => now()->addYear(),
            'monto' => $this->faker->numberBetween(10000, 50000),
        ];
    }
}
