<?php

namespace Database\Factories;

use Cat\Models\Base;
use Illuminate\Database\Eloquent\Factories\Factory;

class BaseFactory extends Factory
{
    protected $model = Base::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->city,
        ];
    }
}
