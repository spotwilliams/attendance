<?php

namespace Cat\Database\Presentismos;

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
                'descripcion' => 'ADAPTACION ESCOLAR',
                'codigo'      => 'AE',
                'corridos'    => 1,
                'color'       => '#d0d4db',
            ],
            ['descripcion' => 'ART', 'codigo' => 'ART', 'corridos' => 0, 'color' => '#726140'],
            [
                'descripcion'   => 'AUSENTE',
                'codigo'        => 'A',
                'injustificado' => 1,
                'corridos'      => 0,
                'color'         => '#e0ba21',
            ],
            [
                'descripcion' => 'COMISIÓN DE SERVICIO',
                'codigo'      => 'CS',
                'corridos'    => 0,
                'color'       => '#3577a3',
            ],
            [
                'descripcion' => 'COMISION GREMIAL',
                'codigo'      => 'CG',
                'corridos'    => 0,
                'color'       => '#1e84c9',
            ],
            [
                'descripcion' => 'CONTROL MASCULINO',
                'codigo'      => 'C/M',
                'corridos'    => 0,
                'color'       => '#56b1ef',
            ],
            [
                'descripcion' => 'DIA NO LABORABLE',
                'codigo'      => 'F',
                'corridos'    => 0,
                'color'       => '#cc9e33',
            ],
            [
                'descripcion' => 'DONACION DE ÓRGANOS',
                'codigo'      => 'DO',
                'corridos'    => 0,
                'color'       => '#2ce226',
            ],
            [
                'descripcion' => 'DONACION DE SANGRE',
                'codigo'      => 'D',
                'corridos'    => 0,
                'color'       => '#3770b7',
            ],
            [
                'descripcion' => 'DUELO O LUTO',
                'codigo'      => 'L',
                'corridos'    => 0,
                'color'       => '#6d6b62',
            ],
            ['descripcion' => 'EXAMEN', 'codigo' => 'X', 'corridos' => 0, 'color' => '#d8bf43'],
            [
                'descripcion' => 'EXIMIDO',
                'codigo'      => 'EX',
                'corridos'    => 0,
                'color'       => '#59595b',
            ],
            [
                'descripcion' => 'EXTENSION MEDICO POR FLIAR',
                'codigo'      => 'A68',
                'corridos'    => 1,
                'color'       => '#7eb262',
            ],
            [
                'descripcion' => 'EXTENSION MEDICO POR HIJO CON DISCAPACIDAD',
                'codigo'      => 'LEY 360',
                'corridos'    => 0,
                'color'       => '#556dba',
            ],
            [
                'descripcion' => 'FESTIVIDAD RELIGIOSA',
                'codigo'      => 'F/R',
                'corridos'    => 0,
                'color'       => '#9edd7c',
            ],
            [
                'descripcion' => 'FRANCO ADMINISTRATIVO',
                'codigo'      => 'F/A',
                'corridos'    => 0,
                'color'       => '#3ab7af',
            ],
            [
                'descripcion' => 'FRANCO COMPENSATORIO',
                'codigo'      => 'F/C',
                'corridos'    => 0,
                'color'       => '#c34cce',
            ],
            [
                'descripcion' => 'FRANCO COMPENSATORIO S/DESC. DE HS',
                'codigo'      => 'F/SD',
                'corridos'    => 0,
                'color'       => '#c3cbe5',
            ],
            [
                'descripcion' => 'FRANCO GINECOLOGICO',
                'codigo'      => 'F/G',
                'corridos'    => 0,
                'color'       => '#d276db',
            ],
            [
                'descripcion' => 'FRANCO POR MUDANZA',
                'codigo'      => 'F/M',
                'corridos'    => 0,
                'color'       => '#4782c1',
            ],
            [
                'descripcion' => 'FRANCO UCCOP',
                'codigo'      => 'F/U',
                'corridos'    => 0,
                'color'       => '#65d8bd',
            ],
            [
                'descripcion' => 'INGRESO DEMORADO',
                'codigo'      => 'ID',
                'corridos'    => 0,
                'color'       => '#f4b653',
            ],
            [
                'descripcion' => 'LICENCIA DEPORTIVA',
                'codigo'      => 'L/D',
                'corridos'    => 0,
                'color'       => '#a86c0b',
            ],
            [
                'descripcion' => 'LICENCIA ESPECIAL',
                'codigo'      => 'LE',
                'corridos'    => 0,
                'color'       => '#c9f2ed',
            ],
            [
                'descripcion' => 'LICENCIA ORDINARIA',
                'codigo'      => 'LO',
                'corridos'    => 0,
                'color'       => '#4bc1b4',
            ],
            [
                'descripcion' => 'LICENCIA SIN GOCE DE HABERES',
                'codigo'      => 'LSG',
                'corridos'    => 0,
                'color'       => '#f9b775',
            ],
            [
                'descripcion' => 'MATERNIDAD',
                'codigo'      => 'N',
                'corridos'    => 0,
                'color'       => '#e050e0',
            ],
            [
                'descripcion' => 'MATRIMONIO',
                'codigo'      => 'MA',
                'corridos'    => 0,
                'color'       => '#ef94ef',
            ],
            [
                'descripcion'   => 'MEDICO INJUSTIFICADO',
                'codigo'        => 'MI',
                'injustificado' => 1,
                'corridos'      => 0,
                'color'         => '#95dff9',
            ],
            [
                'descripcion' => 'MEDICO JUSTIFICADO',
                'codigo'      => 'MJ',
                'corridos'    => 0,
                'color'       => '#6de88f',
            ],
            [
                'descripcion' => 'MEDICO POR FAMILIAR',
                'codigo'      => 'MF',
                'corridos'    => 0,
                'color'       => '#6dad7e',
            ],
            ['descripcion' => 'MEDICO', 'codigo' => 'M', 'corridos' => 0, 'color' => '#37d661'],
            [
                'descripcion' => 'PATERNIDAD',
                'codigo'      => 'PA',
                'corridos'    => 1,
                'color'       => '#12d1b1',
            ],
            [
                'descripcion' => 'PRESENTE',
                'codigo'      => 'P',
                'corridos'    => 0,
                'color'       => '#aebfbc',
            ],
            [
                'descripcion' => 'REPRODUCCION ASISTIDA',
                'codigo'      => 'RA',
                'corridos'    => 0,
                'color'       => '#d278ed',
            ],
            [
                'descripcion' => 'SALIDA ANTICIPADA',
                'codigo'      => 'SA',
                'corridos'    => 0,
                'color'       => '#eaca72',
            ],
            [
                'descripcion' => 'SUSPENSION',
                'codigo'      => 'S',
                'corridos'    => 0,
                'color'       => '#f2784f',
            ],
            ['descripcion' => 'TARDE', 'codigo' => 'T', 'corridos' => 0, 'color' => '#e53720'],
            [
                'descripcion' => 'EXAMEN JUSTIFICADO',
                'codigo'      => 'XJ',
                'corridos'    => 0,
                'color'       => '#eded36',
            ],
            [
                'descripcion' => 'MEDICO POR FAMILIAR JUSTIFICADO',
                'codigo'      => 'MFJ',
                'corridos'    => 0,
                'color'       => '#4c843a',
            ],
            [
                'descripcion' => 'VIOLENCIA DE GENERO',
                'codigo'      => 'VG',
                'corridos'    => 0,
                'color'       => '#c044c4',
            ],
            [
                'descripcion' => 'FRANCO POR NO COBRAR',
                'codigo'      => 'F/NC',
                'corridos'    => 0,
                'color'       => '#a87030',
            ],
            [
                'descripcion' => 'LICENCIA POR ADOPCION',
                'codigo'      => 'L/A',
                'corridos'    => 0,
                'color'       => '#64bdd1',
            ],
            [
                'descripcion' => 'ACCIDENTE EN SERVICIO',
                'codigo'      => 'AT',
                'corridos'    => 0,
                'color'       => '#ff0202',
            ],
            [
                'descripcion' => 'EMBARAZO RIESGOZO',
                'codigo'      => 'MAR',
                'corridos'    => 0,
                'color'       => '#4362ba',
            ],
            [
                'descripcion' => 'EXTENCION MATERNIDAD',
                'codigo'      => 'EXMA',
                'corridos'    => 0,
                'color'       => '#88a1ea',
            ],
            [
                'descripcion' => 'EXTENCION PATERNIDAD',
                'codigo'      => 'EXPA',
                'corridos'    => 0,
                'color'       => '#1546d6',
            ],
            [
                'descripcion' => 'EXTENCION POR ADOPCION',
                'codigo'      => 'EXAD',
                'corridos'    => 0,
                'color'       => '#a9b5d8',
            ],
            [
                'descripcion' => 'FRANQUICIA DE DIRECTOR',
                'codigo'      => 'FRANQUICIA',
                'corridos'    => 0,
                'color'       => '#4786f4',
            ],
        ];
        
        
        foreach ($tipos as $nuevo) {
            \Cat\Models\TipoPresentismo::create($nuevo);
        }
    }
}
