<?php


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


