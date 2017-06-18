<?php
namespace Cat\Database\Seeds\Agentes;

use Illuminate\Database\Seeder;

class EstadosContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = [
            [
                'id'          => 1,
                'estado'      => 'ACTIVO',
                'descripcion' => 'ACTIVO',
                'id_padre'    => null,
            ],
            [
                'id'          => 2,
                'estado'      => 'BAJA',
                'descripcion' => 'BAJA',
                'id_padre'    => null,
            ],
           
            // SUB DE ACTIVO
            [
                'id'          => 3,
                'estado'      => 'COMISION',
                'descripcion' => 'EN COMISION',
                'id_padre'    => 1,
            ],
            // SUB DE BAJA
            [
                'id'          => 4,
                'estado'      => 'FALLECIMIENTO',
                'descripcion' => 'FALLECIMIENTO',
                'id_padre'    => 2,
            ],
            [
                'id'          => 5,
                'estado'      => 'JUBILACION',
                'descripcion' => 'JUBILACION',
                'id_padre'    => 2,
            ],
            [
                'id'          => 6,
                'estado'      => 'RENUNCIA',
                'descripcion' => 'RENUNCIA',
                'id_padre'    => 2,
            ],
            [
                'id'          => 7,
                'estado'      => 'TRANSFERENCIA',
                'descripcion' => 'TRANSFERENCIA',
                'id_padre'    => 2,
            ],
        ];
        
        foreach ($estados as $nuevo) {
            
            \Cat\Models\EstadoContrato::create([
                'id'          => $nuevo['id'],
                'estado'      => $nuevo['estado'],
                'descripcion' => $nuevo['descripcion'],
                'id_padre'    => $nuevo['id_padre'],
            ]);
        }
    }
}
