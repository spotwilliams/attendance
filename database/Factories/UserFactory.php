<?php

namespace Database\Factories;

use Cat\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'cuit' => $this->faker->numerify('20#########'), // 11 digits total
            'remember_token' => Str::random(10),
        ];
    }
}
