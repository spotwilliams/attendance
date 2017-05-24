<?php

use Illuminate\Database\Seeder;

class ContratosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = new \Faker\Generator();
        for ($i = 1; $i < DatabaseSeeder::SIZE_AGENTE; $i++) {
            $contrato = [
                'id_tipo_contrato'   => rand(1, 3),//rand(1, 7),
                'id_estado_contrato' => rand(1, 3),//rand(1, 7),
                'id_agente'          => $i,
                'fecha_firma'        => date('Y-m-d'),
                'fecha_comienzo'     => date('Y-m-d'),
            
            ];
            \Cat\Models\Contrato::create($contrato);
        }
    }
}
