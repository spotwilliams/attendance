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
                'aplica'      => 'TODOS',
                'codigo'      => 'AE',
                'corridos'    => 1,
                'color'       => '#d0d4db',
            ],
            [
                'descripcion' => 'ART',
                'aplica'      => 'SITUACION_REVISTA',
                'codigo'      => 'ART',
                'corridos'    => 0,
                'color'       => '#726140',
            ],
            [
                'descripcion'   => 'AUSENTE',
                'aplica'        => 'TODOS',
                'codigo'        => 'A',
                'injustificado' => 1,
                'corridos'      => 0,
                'color'         => '#e0ba21',
            ],
            [
                'descripcion' => 'COMISIÓN DE SERVICIO',
                'aplica'      => 'SITUACION_REVISTA',
                'codigo'      => 'CS',
                'corridos'    => 0,
                'color'       => '#3577a3',
            ],
            [
                'descripcion' => 'COMISION GREMIAL',
                'aplica'      => 'SITUACION_REVISTA',
                'codigo'      => 'CG',
                'corridos'    => 0,
                'color'       => '#1e84c9',
            ],
            [
                'descripcion' => 'CONTROL MASCULINO',
                'aplica'      => 'TODOS',
                'codigo'      => 'C/M',
                'corridos'    => 0,
                'color'       => '#56b1ef',
            ],
            [
                'descripcion' => 'DIA NO LABORABLE',
                'aplica'      => 'TODOS',
                'codigo'      => 'F',
                'corridos'    => 0,
                'color'       => '#cc9e33',
            ],
            [
                'descripcion' => 'DONACION DE ÓRGANOS',
                'aplica'      => 'SITUACION_REVISTA',
                'codigo'      => 'DO',
                'corridos'    => 0,
                'color'       => '#2ce226',
            ],
            [
                'descripcion' => 'DONACION DE SANGRE',
                'aplica'      => 'TODOS',
                'codigo'      => 'D',
                'corridos'    => 0,
                'color'       => '#3770b7',
            ],
            [
                'descripcion' => 'DUELO O LUTO',
                'aplica'      => 'TODOS',
                'codigo'      => 'L',
                'corridos'    => 0,
                'color'       => '#6d6b62',
            ],
            [
                'descripcion' => 'EXAMEN',
                'aplica'      => 'TODOS',
                'codigo'      => 'X',
                'corridos'    => 0,
                'color'       => '#d8bf43',
            ],
            [
                'descripcion' => 'EXIMIDO',
                'aplica'      => 'TODOS',
                'codigo'      => 'EX',
                'corridos'    => 0,
                'color'       => '#59595b',
            ],
            [
                'descripcion' => 'EXTENSION MEDICO POR FLIAR',
                'aplica'      => 'SITUACION_REVISTA',
                'codigo'      => 'A68',
                'corridos'    => 1,
                'color'       => '#7eb262',
            ],
            [
                'descripcion' => 'EXTENSION MEDICO POR HIJO CON DISCAPACIDAD',
                'aplica'      => 'TODOS',
                'codigo'      => 'LEY 360',
                'corridos'    => 0,
                'color'       => '#556dba',
            ],
            [
                'descripcion' => 'FESTIVIDAD RELIGIOSA',
                'aplica'      => 'TODOS',
                'codigo'      => 'F/R',
                'corridos'    => 0,
                'color'       => '#9edd7c',
            ],
            [
                'descripcion' => 'FRANCO ADMINISTRATIVO',
                'aplica'      => 'SITUACION_REVISTA',
                'codigo'      => 'F/A',
                'corridos'    => 0,
                'color'       => '#3ab7af',
            ],
            [
                'descripcion' => 'FRANCO COMPENSATORIO',
                'aplica'      => 'LOCACION',
                'codigo'      => 'F/C',
                'corridos'    => 0,
                'color'       => '#c34cce',
            ],
            [
                'descripcion' => 'FRANCO COMPENSATORIO S/DESC. DE HS',
                'aplica'      => 'LOCACION',
                'codigo'      => 'F/SD',
                'corridos'    => 0,
                'color'       => '#c3cbe5',
            ],
            [
                'descripcion' => 'FRANCO GINECOLOGICO',
                'aplica'      => 'TODOS',
                'codigo'      => 'F/G',
                'corridos'    => 0,
                'color'       => '#d276db',
            ],
            [
                'descripcion' => 'FRANCO POR MUDANZA',
                'aplica'      => 'TODOS',
                'codigo'      => 'F/M',
                'corridos'    => 0,
                'color'       => '#4782c1',
            ],
            [
                'descripcion' => 'FRANCO UCCOP',
                'aplica'      => 'SITUACION_REVISTA',
                'codigo'      => 'F/U',
                'corridos'    => 0,
                'color'       => '#65d8bd',
            ],
            [
                'descripcion' => 'INGRESO DEMORADO',
                'aplica'      => '',
                'codigo'      => 'ID',
                'corridos'    => 0,
                'color'       => '#f4b653',
            ],
            [
                'descripcion' => 'LICENCIA DEPORTIVA',
                'aplica'      => 'SITUACION_REVISTA',
                'codigo'      => 'L/D',
                'corridos'    => 0,
                'color'       => '#a86c0b',
            ],
            [
                'descripcion' => 'LICENCIA ESPECIAL',
                'aplica'      => 'SITUACION_REVISTA',
                'codigo'      => 'LE',
                'corridos'    => 0,
                'color'       => '#c9f2ed',
            ],
            [
                'descripcion' => 'LICENCIA ORDINARIA',
                'aplica'      => 'TODOS',
                'codigo'      => 'LO',
                'corridos'    => 0,
                'color'       => '#4bc1b4',
            ],
            [
                'descripcion' => 'LICENCIA SIN GOCE DE HABERES',
                'aplica'      => 'LOCACION',
                'codigo'      => 'LSG',
                'corridos'    => 0,
                'color'       => '#f9b775',
            ],
            [
                'descripcion' => 'MATERNIDAD',
                'aplica'      => 'TODOS',
                'codigo'      => 'N',
                'corridos'    => 0,
                'color'       => '#e050e0',
            ],
            [
                'descripcion' => 'MATRIMONIO',
                'aplica'      => 'TODOS',
                'codigo'      => 'MA',
                'corridos'    => 0,
                'color'       => '#ef94ef',
            ],
            [
                'descripcion'   => 'MEDICO INJUSTIFICADO',
                'aplica'        => 'TODOS',
                'codigo'        => 'MI',
                'injustificado' => 1,
                'corridos'      => 0,
                'color'         => '#95dff9',
            ],
            [
                'descripcion' => 'MEDICO JUSTIFICADO',
                'aplica'      => '',
                'codigo'      => 'MJ',
                'corridos'    => 0,
                'color'       => '#6de88f',
            ],
            [
                'descripcion' => 'MEDICO POR FAMILIAR',
                'aplica'      => 'TODOS',
                'codigo'      => 'MF',
                'corridos'    => 0,
                'color'       => '#6dad7e',
            ],
            [
                'descripcion' => 'MEDICO',
                'aplica'      => 'TODOS',
                'codigo'      => 'M',
                'corridos'    => 0,
                'color'       => '#37d661',
            ],
            [
                'descripcion' => 'PATERNIDAD',
                'aplica'      => 'TODOS',
                'codigo'      => 'PA',
                'corridos'    => 1,
                'color'       => '#12d1b1',
            ],
            [
                'descripcion' => 'PRESENTE',
                'aplica'      => 'TODOS',
                'codigo'      => 'P',
                'corridos'    => 0,
                'color'       => '#aebfbc',
            ],
            [
                'descripcion' => 'REPRODUCCION ASISTIDA',
                'aplica'      => 'TODOS',
                'codigo'      => 'RA',
                'corridos'    => 0,
                'color'       => '#d278ed',
            ],
            [
                'descripcion' => 'SALIDA ANTICIPADA',
                'aplica'      => 'TODOS',
                'codigo'      => 'SA',
                'corridos'    => 0,
                'color'       => '#eaca72',
            ],
            [
                'descripcion' => 'SUSPENSION',
                'aplica'      => 'TODOS',
                'codigo'      => 'S',
                'corridos'    => 0,
                'color'       => '#f2784f',
            ],
            [
                'descripcion' => 'TARDE',
                'aplica'      => 'TODOS',
                'codigo'      => 'T',
                'corridos'    => 0,
                'color'       => '#e53720',
            ],
            [
                'descripcion' => 'EXAMEN JUSTIFICADO',
                'aplica'      => '',
                'codigo'      => 'XJ',
                'corridos'    => 0,
                'color'       => '#eded36',
            ],
            [
                'descripcion' => 'MEDICO POR FAMILIAR JUSTIFICADO',
                'aplica'      => '',
                'codigo'      => 'MFJ',
                'corridos'    => 0,
                'color'       => '#4c843a',
            ],
            [
                'descripcion' => 'VIOLENCIA DE GENERO',
                'aplica'      => 'TODOS',
                'codigo'      => 'VG',
                'corridos'    => 0,
                'color'       => '#c044c4',
            ],
            [
                'descripcion' => 'FRANCO POR NO COBRAR',
                'aplica'      => 'LOCACION',
                'codigo'      => 'F/NC',
                'corridos'    => 0,
                'color'       => '#a87030',
            ],
            [
                'descripcion' => 'LICENCIA POR ADOPCION',
                'aplica'      => 'TODOS',
                'codigo'      => 'L/A',
                'corridos'    => 0,
                'color'       => '#64bdd1',
            ],
            [
                'descripcion' => 'ACCIDENTE EN SERVICIO',
                'aplica'      => 'LOCACION',
                'codigo'      => 'AT',
                'corridos'    => 0,
                'color'       => '#ff0202',
            ],
            [
                'descripcion' => 'EMBARAZO RIESGOZO',
                'aplica'      => 'TODOS',
                'codigo'      => 'MAR',
                'corridos'    => 0,
                'color'       => '#4362ba',
            ],
            [
                'descripcion' => 'EXTENCION MATERNIDAD',
                'aplica'      => 'TODOS',
                'codigo'      => 'EXMA',
                'corridos'    => 0,
                'color'       => '#88a1ea',
            ],
            [
                'descripcion' => 'EXTENCION PATERNIDAD',
                'aplica'      => 'SITUACION_REVISTA',
                'codigo'      => 'EXPA',
                'corridos'    => 0,
                'color'       => '#1546d6',
            ],
            [
                'descripcion' => 'EXTENCION POR ADOPCION',
                'aplica'      => 'SITUACION_REVISTA',
                'codigo'      => 'EXAD',
                'corridos'    => 0,
                'color'       => '#a9b5d8',
            ],
            [
                'descripcion' => 'FRANQUICIA DE DIRECTOR',
                'aplica'      => 'SITUACION_REVISTA',
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
