<?php

namespace Database\Seeders\Presentismos;

use Cat\Models\TipoPresentismo;
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
            // ── Positive (present, working) ── emerald/teal ──
            [
                'descripcion' => 'PRESENTE',
                'aplica' => 'TODOS',
                'codigo' => 'P',
                'injustificado' => 0,
                'corridos' => 0,
                'color' => '#10b981',
                'color_letra' => '#ffffff',
            ],

            // ── Negative (absent, late, suspension) ── amber/red ──
            [
                'descripcion' => 'AUSENTE',
                'aplica' => 'TODOS',
                'codigo' => 'A',
                'injustificado' => true,
                'corridos' => 0,
                'color' => '#f59e0b',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'TARDE',
                'aplica' => 'TODOS',
                'codigo' => 'T',
                'corridos' => 0,
                'color' => '#ef4444',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'SUSPENSION',
                'aplica' => 'TODOS',
                'codigo' => 'S',
                'corridos' => 0,
                'color' => '#dc2626',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'INGRESO DEMORADO',
                'aplica' => '',
                'codigo' => 'ID',
                'corridos' => 0,
                'color' => '#fb923c',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'SALIDA ANTICIPADA',
                'aplica' => 'TODOS',
                'codigo' => 'SA',
                'corridos' => 0,
                'color' => '#f97316',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'ACCIDENTE EN SERVICIO',
                'aplica' => 'LOCACION',
                'codigo' => 'AT',
                'corridos' => 0,
                'color' => '#b91c1c',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'ART',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'ART',
                'corridos' => 0,
                'color' => '#991b1b',
                'color_letra' => '#ffffff',
            ],

            // ── Medical/Health ── cyan/teal ──
            [
                'descripcion' => 'MEDICO',
                'aplica' => 'TODOS',
                'codigo' => 'M',
                'corridos' => 0,
                'color' => '#06b6d4',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'MEDICO JUSTIFICADO',
                'aplica' => '',
                'codigo' => 'MJ',
                'corridos' => 0,
                'color' => '#22d3ee',
                'color_letra' => '#164e63',
            ],
            [
                'descripcion' => 'CONTROL MASCULINO',
                'aplica' => 'TODOS',
                'codigo' => 'C/M',
                'corridos' => 0,
                'color' => '#67e8f9',
                'color_letra' => '#164e63',
            ],
            [
                'descripcion' => 'EXTENSION MEDICO POR FLIAR',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'A68',
                'corridos' => 1,
                'color' => '#0891b2',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'EXTENSION MEDICO POR HIJO CON DISCAPACIDAD',
                'aplica' => 'TODOS',
                'codigo' => 'LEY 360',
                'corridos' => 0,
                'color' => '#0e7490',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'MEDICO POR FAMILIAR JUSTIFICADO',
                'aplica' => '',
                'codigo' => 'MFJ',
                'corridos' => 0,
                'color' => '#155e75',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'EMBARAZO RIESGOZO',
                'aplica' => 'TODOS',
                'codigo' => 'MAR',
                'corridos' => 0,
                'color' => '#0d9488',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'REPRODUCCION ASISTIDA',
                'aplica' => 'TODOS',
                'codigo' => 'RA',
                'corridos' => 0,
                'color' => '#14b8a6',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'VIOLENCIA DE GENERO',
                'aplica' => 'TODOS',
                'codigo' => 'VG',
                'corridos' => 0,
                'color' => '#115e59',
                'color_letra' => '#ffffff',
            ],

            // ── Leave/Franco ── violet/indigo ──
            [
                'descripcion' => 'LICENCIA ORDINARIA',
                'aplica' => 'TODOS',
                'codigo' => 'LO',
                'corridos' => 0,
                'color' => '#8b5cf6',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'LICENCIA ESPECIAL',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'LE',
                'corridos' => 0,
                'color' => '#a78bfa',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'LICENCIA ESPECIAL',
                'aplica' => 'TODOS',
                'codigo' => 'LES',
                'injustificado' => false,
                'corridos' => 0,
                'color' => '#7c3aed',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'LICENCIA DEPORTIVA',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'L/D',
                'corridos' => 0,
                'color' => '#6d28d9',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'LICENCIA SIN GOCE DE HABERES',
                'aplica' => 'LOCACION',
                'codigo' => 'LSG',
                'corridos' => 0,
                'color' => '#5b21b6',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'LICENCIA POR ADOPCION',
                'aplica' => 'TODOS',
                'codigo' => 'L/A',
                'corridos' => 0,
                'color' => '#c4b5fd',
                'color_letra' => '#4c1d95',
            ],
            [
                'descripcion' => 'FRANCO ADMINISTRATIVO',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'F/A',
                'corridos' => 0,
                'color' => '#818cf8',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'FRANCO COMPENSATORIO',
                'aplica' => 'LOCACION',
                'codigo' => 'F/C',
                'corridos' => 0,
                'color' => '#6366f1',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'FRANCO COMPENSATORIO S/DESC. DE HS',
                'aplica' => 'LOCACION',
                'codigo' => 'F/SD',
                'corridos' => 0,
                'color' => '#a5b4fc',
                'color_letra' => '#3730a3',
            ],
            [
                'descripcion' => 'FRANCO GINECOLOGICO',
                'aplica' => 'TODOS',
                'codigo' => 'F/G',
                'corridos' => 0,
                'color' => '#c7d2fe',
                'color_letra' => '#3730a3',
            ],
            [
                'descripcion' => 'FRANCO POR MUDANZA',
                'aplica' => 'TODOS',
                'codigo' => 'F/M',
                'corridos' => 0,
                'color' => '#4f46e5',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'FRANCO UCCOP',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'F/U',
                'corridos' => 0,
                'color' => '#4338ca',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'FRANCO POR NO COBRAR',
                'aplica' => 'LOCACION',
                'codigo' => 'F/NC',
                'corridos' => 0,
                'color' => '#3730a3',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'FRANQUICIA DE DIRECTOR',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'FRANQUICIA',
                'corridos' => 0,
                'color' => '#312e81',
                'color_letra' => '#ffffff',
            ],

            // ── Family (maternity, paternity, adoption) ── pink/rose ──
            [
                'descripcion' => 'MATRIMONIO',
                'aplica' => 'TODOS',
                'codigo' => 'MA',
                'corridos' => 0,
                'color' => '#ec4899',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'EXTENCION MATERNIDAD',
                'aplica' => 'TODOS',
                'codigo' => 'EXMA',
                'corridos' => 0,
                'color' => '#f472b6',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'EXTENCION PATERNIDAD',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'EXPA',
                'corridos' => 0,
                'color' => '#db2777',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'EXTENCION POR ADOPCION',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'EXAD',
                'corridos' => 0,
                'color' => '#be185d',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'PATERNIDAD FLIA NUMEROSA',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'PN',
                'corridos' => 0,
                'color' => '#f9a8d4',
                'color_letra' => '#831843',
            ],
            [
                'descripcion' => 'PATERNIDAD NAC MULTIPLE',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'PM',
                'corridos' => 0,
                'color' => '#fbcfe8',
                'color_letra' => '#831843',
            ],
            [
                'descripcion' => 'MATERNIDAD FLIA NUMEROSA',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'NN',
                'corridos' => 0,
                'color' => '#9d174d',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'MATERNIDAD NAC MULTIPLE',
                'aplica' => 'TODOS',
                'codigo' => 'NM',
                'corridos' => 0,
                'color' => '#be185d',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'EXTENSION MATERNIDAD',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'NE',
                'corridos' => 0,
                'color' => '#e879a0',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'ADOPCION TITULAR',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'AD',
                'corridos' => 0,
                'color' => '#f43f5e',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'EXTENSION ADOPCION TITULAR',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'ADE',
                'corridos' => 0,
                'color' => '#fb7185',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'ADOPCION NO TITULAR',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'ADN',
                'corridos' => 0,
                'color' => '#fda4af',
                'color_letra' => '#881337',
            ],

            // ── Special/Neutral (exempt, non-working, commission) ── slate/gray ──
            [
                'descripcion' => 'EXIMIDO',
                'aplica' => 'TODOS',
                'codigo' => 'EX',
                'corridos' => 0,
                'color' => '#64748b',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'DIA NO LABORABLE',
                'aplica' => 'TODOS',
                'codigo' => 'F',
                'injustificado' => 0,
                'corridos' => 0,
                'color' => '#94a3b8',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'COMISIÓN DE SERVICIO',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'CS',
                'corridos' => 0,
                'color' => '#475569',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'COMISION GREMIAL',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'CG',
                'corridos' => 0,
                'color' => '#334155',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'DUELO O LUTO',
                'aplica' => 'TODOS',
                'codigo' => 'L',
                'corridos' => 0,
                'color' => '#1e293b',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'ADAPTACION ESCOLAR',
                'aplica' => 'TODOS',
                'codigo' => 'AE',
                'corridos' => 1,
                'color' => '#cbd5e1',
                'color_letra' => '#334155',
            ],
            [
                'descripcion' => 'FESTIVIDAD RELIGIOSA',
                'aplica' => 'TODOS',
                'codigo' => 'F/R',
                'corridos' => 0,
                'color' => '#e2e8f0',
                'color_letra' => '#334155',
            ],
            [
                'descripcion' => 'DONACION DE ÓRGANOS',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'DO',
                'corridos' => 0,
                'color' => '#0f172a',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'EXAMEN JUSTIFICADO',
                'aplica' => '',
                'codigo' => 'XJ',
                'corridos' => 0,
                'color' => '#a8a29e',
                'color_letra' => '#ffffff',
            ],
        ];

        foreach ($tipos as $nuevo) {
            if (!isset($nuevo['injustificado'])) {
                $array = array_merge($nuevo, ['injustificado' => 1]);
            } else {
                $array = $nuevo;
            }
            TipoPresentismo::create($array);
        }

        $tiposNews = $this->mismosCodigosDiffDias();
        foreach ($tiposNews as $nuevo) {
            if (!isset($nuevo['injustificado'])) {
                $array = array_merge($nuevo, ['injustificado' => true]);
            } else {
                $array = $nuevo;
            }
            TipoPresentismo::create($array);
        }
    }

    private function mismosCodigosDiffDias(): array
    {
        return [
            // ── Family (duplicated per contract type) ── pink ──
            [
                'descripcion' => 'MATERNIDAD',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'N',
                'corridos' => 0,
                'color' => '#ec4899',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'PATERNIDAD',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'PA',
                'corridos' => 1,
                'color' => '#f472b6',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'MATERNIDAD',
                'aplica' => 'LOCACION',
                'codigo' => 'N',
                'corridos' => 0,
                'color' => '#ec4899',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'PATERNIDAD',
                'aplica' => 'LOCACION',
                'codigo' => 'PA',
                'corridos' => 1,
                'color' => '#f472b6',
                'color_letra' => '#ffffff',
            ],

            // ── Medical (duplicated per contract type) ── cyan ──
            [
                'descripcion' => 'MEDICO POR FAMILIAR',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'MF',
                'corridos' => 0,
                'color' => '#0891b2',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'MEDICO POR FAMILIAR',
                'aplica' => 'LOCACION',
                'codigo' => 'MF',
                'corridos' => 0,
                'color' => '#0891b2',
                'color_letra' => '#ffffff',
            ],

            // ── Neutral (duplicated per contract type) ── slate ──
            [
                'descripcion' => 'DONACION DE SANGRE',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'D',
                'corridos' => 0,
                'color' => '#475569',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'EXAMEN',
                'aplica' => 'SITUACION_REVISTA',
                'codigo' => 'X',
                'corridos' => 0,
                'color' => '#a8a29e',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'DONACION DE SANGRE',
                'aplica' => 'LOCACION',
                'codigo' => 'D',
                'corridos' => 0,
                'color' => '#475569',
                'color_letra' => '#ffffff',
            ],
            [
                'descripcion' => 'EXAMEN',
                'aplica' => 'LOCACION',
                'codigo' => 'X',
                'corridos' => 0,
                'color' => '#d6d3d1',
                'color_letra' => '#44403c',
            ],
        ];
    }
}
