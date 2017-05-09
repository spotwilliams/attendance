<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Cat\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

// Agente
$factory->define(\Cat\Models\Agente::class, function (Faker\Generator $faker) {
    return [
        'nombre'              => $faker->name,
        'apellido'            => $faker->lastName,
        'dni'                 => rand(30000000, 50000000),
        'fecha_nacimiento'    => $faker->date('d-m-Y'),
        'cuit'                => $faker->word,
        'id_base'             => rand(1, 20),
        'id_area'             => rand(1, 20),
        'id_domicilio'        => rand(1, 20),
        'id_contrato'         => rand(1, 20),
        'id_dias_disponibles' => rand(1, 20),
    ];
});

// Bases
$factory->define(\Cat\Models\Base::class, function (Faker\Generator $faker) {
    return [
        'nombre' => $faker->city,
    ];
});

// Area
$factory->define(\Cat\Models\Area::class, function (Faker\Generator $faker) {
    return [
        'direccion'   => $faker->name,
        'gerencia'    => $faker->word,
        'subgerencia' => $faker->domainName,
    ];
});

// Domicilio
$factory->define(\Cat\Models\Domicilio::class, function (Faker\Generator $faker) {
    return [
        'calle'        => $faker->streetName,
        'numero'       => $faker->numberBetween(1, 100),
        'departamento' => $faker->numberBetween(1, 15),
        'piso'         => $faker->numberBetween(1, 4),
        'barrio'       => $faker->locale,
        'provincia'    => $faker->country,
    ];
});


// Contrato
$factory->define(\Cat\Models\Contrato::class, function (Faker\Generator $faker) {
    
    return [
        'tipo_contrato'      => $faker->randomElement([
            'TRANSITORIA',
            'PLANTA',
            'LOCACION',
            '959/07',
            'PLANTA DE GABINETE',
            'GERENTE REC. MAT.',
            'SUBGERENTE AREA PERS.º',
        ]),
        'fecha_firma'        => $faker->date(),
        'fecha_comienzo'     => $faker->date(),
        'id_estado_contrato' => rand(1, 7),
    ];
});