<?php

namespace Database\Factories;

use Cat\Models\TipoContrato;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoContratoFactory extends Factory
{
    protected $model = TipoContrato::class;

    public function definition()
    {
        return [
            'codigo' => $this->faker->randomElement(['LOCACION', 'SITUACION_REVISTA']),
            'descripcion' => $this->faker->words(3, true),
        ];
    }

    public function locacion()
    {
        return $this->state(function (array $attributes) {
            return [
                'codigo' => TipoContrato::TIPO_LOCACION,
                'descripcion' => 'Locación de Servicios',
            ];
        });
    }

    public function situacionRevista()
    {
        return $this->state(function (array $attributes) {
            return [
                'codigo' => TipoContrato::TIPO_SITUACION_REVISTA,
                'descripcion' => 'Situación de Revista',
            ];
        });
    }
}
