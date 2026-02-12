<?php

namespace Database\Factories;

use Cat\Models\TipoPresentismo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoPresentismoFactory extends Factory
{
    protected $model = TipoPresentismo::class;

    public function definition()
    {
        $codigos = ['P', 'A', 'T', 'EX', 'LM', 'F'];

        return [
            'codigo' => $this->faker->randomElement($codigos),
            'aplica' => $this->faker->randomElement(['LOCACION', 'SITUACION_REVISTA', 'TODOS', '']),
            'descripcion' => $this->faker->words(3, true),
            'color' => $this->faker->hexColor,
            'color_letra' => $this->faker->randomElement(['#000000', '#FFFFFF', '#333']),
            'injustificado' => $this->faker->boolean(20),
            'corridos' => $this->faker->boolean(30),
        ];
    }

    public function presente()
    {
        return $this->state(function (array $attributes) {
            return [
                'codigo' => 'P',
                'descripcion' => 'Presente',
                'aplica' => 'TODOS',
                'injustificado' => false,
                'corridos' => false,
            ];
        });
    }

    public function ausente()
    {
        return $this->state(function (array $attributes) {
            return [
                'codigo' => 'A',
                'descripcion' => 'Ausente',
                'aplica' => 'TODOS',
                'injustificado' => true,
                'corridos' => false,
            ];
        });
    }
}
