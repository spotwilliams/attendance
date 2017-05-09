<?php

use Illuminate\Database\Seeder;

class TiposPresentismoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            [
                'id'              => 1,
                'id_padre'        => null,
                'codigo'          => 'PRESENTE',
                'descripcion'     => 'Presente',
                'dias_permitidos' => rand(1, 10),
            ],
            [
                'id'              => 2,
                'id_padre'        => null,
                'codigo'          => 'INJUSTIFICADO',
                'descripcion'     => 'Ausente injustificado',
                'dias_permitidos' => 0,
            ],
            [
                'id'              => 3,
                'id_padre'        => 2,
                'codigo'          => 'MEDICO',
                'descripcion'     => 'Ausente con permiso medico',
                'dias_permitidos' => rand(1, 10),
            ],
            [
                'id'              => 4,
                'id_padre'        => 2,
                'codigo'          => 'ESTUDIO',
                'descripcion'     => 'Dias de estudio',
                'dias_permitidos' => rand(1, 10),
            ],
            [
                'id'              => 5,
                'id_padre'        => 2,
                'codigo'          => 'JUDIO',
                'descripcion'     => 'Festividad judia',
                'dias_permitidos' => rand(1, 10),
            ],
        ];
        
        foreach ($tipos as $nuevo) {
            \Cat\Models\TipoPresentismo::create($nuevo);
        }
    }
}
