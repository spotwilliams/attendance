<?php

namespace Database\Factories;

use Cat\Models\EstadoContrato;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstadoContratoFactory extends Factory
{
    protected $model = EstadoContrato::class;

    public function definition()
    {
        return [
            'estado' => $this->faker->randomElement(['ACTIVO', 'BAJA', 'COMISION']),
            'descripcion' => $this->faker->words(2, true),
            'id_padre' => null,
        ];
    }

    public function activo()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => 'ACTIVO',
                'descripcion' => 'ACTIVO',
                'id_padre' => null,
            ];
        });
    }

    public function baja()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => 'BAJA',
                'descripcion' => 'BAJA',
                'id_padre' => null,
            ];
        });
    }
}
