<?php

namespace Database\Factories;

use Cat\Models\Turno;
use Illuminate\Database\Eloquent\Factories\Factory;

class TurnoFactory extends Factory
{
    protected $model = Turno::class;

    public function definition()
    {
        $turnos = ['M', 'T', 'N', 'FSD', 'FSN', 'FSI'];

        return [
            'codigo' => $this->faker->randomElement($turnos),
            'descripcion' => $this->faker->words(3, true),
        ];
    }
}
