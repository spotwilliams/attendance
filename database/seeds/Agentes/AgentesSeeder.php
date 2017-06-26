<?php

namespace Cat\Database\Seeds\Agentes;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Cat\Modules\Agentes\Services\Registro\Store\Laborales;
use Cat\Modules\Agentes\Services\Registro\Store\Operativos;
use Cat\Modules\Agentes\Services\Registro\Store\Personales;
use Faker\Provider\es_AR\PhoneNumber;
use Faker\Provider\Internet;
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
        
        $cuit = new \Faker\Provider\Barcode($faker);
        $faker->addProvider($cuit);
        
        $email = new Internet($faker);
        $faker->addProvider($email);
        
        $faker->addProvider(new PhoneNumber($faker));
        $tiposContratos = TipoContrato::all()->count();
        $base           = Base::all()->count();
        $turno          = Turno::all()->count();
        for ($i = 1; $i < \DatabaseSeeder::SIZE_AGENTE; $i++) {
            $agente = [
                'id'               => $i,
                'nombre'           => $faker->name(),
                'apellido'         => $faker->lastName(),
                'dni'              => rand(3000000, 50000000) + rand(0, 999999),
                'fecha_nacimiento' => date('Y-m-d'),
                'cuit'             => $faker->isbn13(),
                'estado_civil'     => 'CASADO',
                'sexo'             => 'H',
                'email'            => $faker->email(),
                'telefono'         => $faker->phoneNumber(false),
            ];
            $age    = new Agente($agente);
            (new Personales($age))->execute();
            
            $laboral = [
                'id_sial'            => rand(1, 100),
                'ficha'              => rand(1, 100),
                'monto'              => rand(10000, 90000),
                'fecha_ingreso'      => date('Y-m-d'),
                'id_estado_contrato' => 1,
                'id_tipo_contrato'   => rand(7, 8)//rand(1, $tiposContratos - 1),
            ];
            (new Laborales($age, $laboral))->execute();
            $operativos = [
                'agente'             => $i,
                'id_gerencia'        => 1,
                'id_area'            => 1,
                'id_cargo'           => 1,
                'id_funcion'         => 1,
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
