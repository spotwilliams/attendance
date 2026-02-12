<?php

namespace Database\Factories;

use Cat\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    protected $model = Area::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->company,
        ];
    }
}
