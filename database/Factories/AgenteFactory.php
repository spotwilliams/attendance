<?php

namespace Database\Factories;

use Cat\Models\Agente;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgenteFactory extends Factory
{
    protected $model = Agente::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName,
            'dni' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'fecha_nacimiento' => $this->faker->date('Y-m-d', '-25 years'),
            'cuit' => $this->faker->numerify('20#########'), // 11 digits total
            'telefono_particular' => $this->faker->numerify('##########'),
            'telefono_casa' => $this->faker->optional()->numerify('##########'),
            'telefono_ht' => $this->faker->optional()->numerify('##########'),
            'email' => $this->faker->unique()->safeEmail,
            'email_gobierno' => $this->faker->optional()->email,
            'estado_civil' => $this->faker->randomElement(['Soltero', 'Casado', 'Divorciado', 'Viudo']),
            'sexo' => $this->faker->randomElement(['M', 'F']),
            'avatar' => 'default.jpg',
            'observacion' => $this->faker->optional()->sentence,
            'profesion' => $this->faker->optional()->jobTitle,
        ];
    }
}
