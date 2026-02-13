<?php

namespace Database\Factories;

use Cat\Models\Area;
use Cat\Models\Cargo;
use Cat\Models\Funcion;
use Cat\Models\Gerencia;
use Cat\Models\Horario;
use Cat\Models\Operativo;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Turno;
use Illuminate\Database\Eloquent\Factories\Factory;

class OperativoFactory extends Factory
{
    protected $model = Operativo::class;

    public function definition()
    {
        return [
            'id_agente' => Agente::factory(),
            'id_base' => Base::factory(),
            'id_turno' => Turno::factory(),
            'id_gerencia' => Gerencia::factory(),
            'id_area' => Area::factory(),
            'id_cargo' => Cargo::factory(),
            'id_funcion' => Funcion::factory(),
            'funcion_especifica' => 'Función Específica ' . $this->faker->word(),
            'id_horario' => Horario::factory(),
        ];
    }
}
