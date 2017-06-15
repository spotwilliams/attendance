<?php

namespace Cat\Database\Seeds\Agentes;

use Cat\Models\Agente;
use Cat\Modules\Agentes\Services\Registro\Store\Laborales;
use Cat\Modules\Agentes\Services\Registro\Store\Operativos;
use Cat\Modules\Agentes\Services\Registro\Store\Personales;
use Illuminate\Database\Seeder;

class AgentesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = new \Faker\Generator();
        
        $person = new \Faker\Provider\en_US\Person($faker);
        $faker->addProvider($person);
        
        $cuit = new \Faker\Provider\Uuid($faker);
        $faker->addProvider($cuit);
        
        for ($i = 1; $i < \DatabaseSeeder::SIZE_AGENTE; $i++) {
            $agente = [
                'id'               => $i,
                'nombre'           => $faker->name(),
                'apellido'         => $faker->lastName(),
                'dni'              => rand(3000000, 50000000) + rand(0, 9999),
                'fecha_nacimiento' => date('Y-m-d'),
                'cuit'             => $faker->uuid(),
                'estado_civil'     => 'CASADO',
            ];
            $age    = new Agente($agente);
            (new Personales($age))->execute();
            
            $laboral = [
                'id_sial'            => rand(1, 100),
                'ficha'              => rand(1, 100),
                'monto'              => rand(10000, 90000),
                'fin_semana'         => rand(0, 1),
                'fecha_ingreso'      => date('Y-m-d'),
                'id_estado_contrato' => 1,
                'id_tipo_contrato'   => 3,
            ];
            (new Laborales($age, $laboral))->execute();
            $operativos = [
                'agente'      => $i,
                'id_gerencia' => 1,
                'id_area'     => 1,
                'id_cargo'    => 1,
                'id_funcion'  => 1,
                'id_base'     => rand(1, 17),
                'id_turno'    => 1,
                'id_horario'  => 1,
            ];
            (new Operativos($operativos))->execute();
        }
    }
}
