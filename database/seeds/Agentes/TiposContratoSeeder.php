<?php
namespace Cat\Database\Seeds\Agentes;

use Illuminate\Database\Seeder;

class TiposContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            ['id' => 1, 'descripcion' => 'Planta transitoria', 'codigo' => 'TRANSITORIA'],
            ['id' => 2, 'descripcion' => 'Planta permanente', 'codigo' => 'PLANTA'],
            ['id' => 3, 'descripcion' => 'Locacion de servicios', 'codigo' => 'LOCACION'],
            ['id' => 4, 'descripcion' => 'Tipo 959', 'codigo' => '959/07'],
            ['id' => 5, 'descripcion' => 'Planta de gabinete', 'codigo' => 'GABINETE'],
            ['id' => 6, 'descripcion' => 'Gerente recursos materiales', 'codigo' => 'GERENTE_REC_MAT'],
            ['id' => 7, 'descripcion' => 'Subgerente area personal', 'codigo' => 'SUB_AREA_PERSONAL'],
        ];
        
        
        foreach ( $tipos as $nuevo) {
            \Cat\Models\TipoContrato::create($nuevo);
        }
    }
}
