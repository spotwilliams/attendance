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
                'descripcion' => 'Contrato activo',
                'id_padre'    => null,
            ],
            [
                'id'          => 2,
                'estado'      => 'BAJA',
                'descripcion' => 'Contrato inactivo',
                'id_padre'    => null,
            ],
            [
                'id'          => 3,
                'estado'      => 'COMISION',
                'descripcion' => 'Contrato inactivo por comision',
                'id_padre'    => 2,
            ],
            [
                'id'          => 4,
                'estado'      => 'FALLECIMIENTO',
                'descripcion' => 'Contrato inactivo por fallecimiento',
                'id_padre'    => 2,
            ],
            [
                'id'          => 5,
                'estado'      => 'JUBILACION',
                'descripcion' => 'Contrato inactivo por jubilacion',
                'id_padre'    => 2,
            ],
            [
                'id'          => 6,
                'estado'      => 'RENUNCIA',
                'descripcion' => 'Contrato inactivo por renuncia',
                'id_padre'    => 2,
            ],
            [
                'id'          => 7,
                'estado'      => 'TRANSFERENCIA',
                'descripcion' => 'Contrato inactivo por transferencia',
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
