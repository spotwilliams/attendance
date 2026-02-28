<?php

namespace Database\Seeders\Agentes;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Cat\Modules\Agentes\Services\Registro\Store\Laborales;
use Cat\Modules\Agentes\Services\Registro\Store\Operativos;
use Cat\Modules\Agentes\Services\Registro\Store\Personales;
use Faker\Provider\es_AR\PhoneNumber;
use Illuminate\Database\Seeder;

class AgentesSeeder extends Seeder
{
    const POPULATION_SIZE = 500;

    public function run()
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new PhoneNumber($faker));
        $tiposContratos = TipoContrato::all()->count();
        $base           = Base::all()->count();
        $turno          = Turno::all()->count();
        for ($i = 1; $i < self::POPULATION_SIZE; $i++) {
            $agente = [
                'nombre'           => $faker->name(),
                'apellido'         => $faker->lastName(),
                'dni'              => $faker->unique()->numerify('########'),
                'fecha_nacimiento' => $faker->date('Y-m-d', '-20 years'),
                'cuit'             => '20' . $faker->unique()->numerify('########') . '0',
                'estado_civil'     => $faker->randomElement(['SOLTERO', 'CASADO', 'DIVORCIADO', 'VIUDO']),
                'sexo'             => $faker->randomElement(['H', 'M']),
                'email'            => $faker->email(),
                'telefono_particular' => $faker->numerify('##########'),
            ];
            $age    = new Agente($agente);
            (new Personales($age))->execute();
            
            $laboral = [
                'id_sial'                => rand(1, 100),
                'ficha'                  => rand(1, 100),
                'monto'                  => rand(10000, 90000),
                'fecha_ingreso'          => $faker->date('Y-m-d', '-2 years'),
                'fecha_ingreso_gobierno' => $faker->date('Y-m-d', '-3 years'),
                'fecha_fin'              => $faker->date('Y-m-d', '+1 year'),
                'tipo_inscripcion'       => $faker->randomElement(['Regimen general', 'Monotributo']),
                'id_estado_contrato'     => 1,
                'id_tipo_contrato'       => rand(1, $tiposContratos - 1),
            ];
            (new Laborales($age, $laboral))->execute();
            $operativos = [
                'agente'             => $i,
                'id_gerencia'        => rand(1, 10),
                'id_area'            => rand(1, 36),
                'id_cargo'           => rand(1, 9),
                'id_funcion'         => rand(1, 3),
                'funcion_especifica' => '',
                'id_base'            => rand(1, $base - 1),
                'id_turno'           => rand(1, $turno - 1),
                'hora_entrada'       => 1,
                'hora_salida'        => 1,
                'eximido'            => 1,
                'rotativo'           => 1,
            ];
            (new Operativos($operativos))->execute();
        }
    }
}
