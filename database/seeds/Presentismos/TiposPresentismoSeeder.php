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
                'codigo'      => 'PRESENTE',
                'descripcion' => 'Presente',
                'color'       => '#3286f4',
                'corridos'    => 0,
            ],
            [
                'codigo'      => 'INJUSTIFICADO',
                'descripcion' => 'Injustificado',
                'color'       => '#4586f4',
                'corridos'    => 0,
            ],
            [
                'codigo'      => 'MEDICO',
                'color'       => '#4566f4',
                'descripcion' => 'Medicos y Medicos x Fliar.',
            ],
            [
                'codigo'      => 'EXAMEN',
                'color'       => '#4676f4',
                'descripcion' => 'Examen',
            ],
            [
                'codigo'      => 'FRANQUICIA',
                'color'       => '#4786f4',
                'descripcion' => 'Franquicia de Director',
                'corridos'    => 1,
            ],
            [
                'codigo'      => 'MATRIMONIO',
                'color'       => '#4896f4',
                'descripcion' => 'Matrimonio',
                'corridos'    => 1,
            ],
            [
                'codigo'      => 'DONACION_SANGRE',
                'color'       => '#4906f4',
                'descripcion' => 'Donacion de Sangre',
            ],
            [
                'codigo'      => 'FALLECIMIENTO_FAMILIAR',
                'color'       => '#428124',
                'descripcion' => 'Fallecimiento de Fliar. Directo (conyugue-hijos-padres-nietos-hermanos-abuelos)',
            ],
            [
                'codigo'      => 'PREVENCION',
                'color'       => '#4ab6f4',
                'descripcion' => 'Control de Prevención',
            ],
            [
                'codigo'      => 'VIOLENCIA_GENERO',
                'color'       => '#42ca6f4',
                'descripcion' => 'Viloencia de Genero',
            ],
            [
                'codigo'      => 'MATERNIDAD',
                'color'       => '#42acf4',
                'descripcion' => 'Maternidad',
            ],
            [
                'codigo'      => 'MATERNIDAD_SIN_GOCE',
                'color'       => '#41a86f4',
                'descripcion' => 'Maternidad Extención sin goce)',
                'corridos'    => 1,
            ],
            [
                'codigo'      => 'ESCOLAR',
                'color'       => '#422bf4',
                'descripcion' => 'Adaptación Escolar (Jardín Maternal- Preescolar y 1er. Grado)',
                'corridos'    => 1,
            
            ],
            [
                'codigo'      => 'PATERNIDAD',
                'color'       => '#423cf4',
                'descripcion' => 'Paternidad',
            ],
            [
                'codigo'      => 'MUDANZA',
                'color'       => '#424df4',
                'descripcion' => 'Mudanza',
            ],
            [
                'codigo'      => 'ACCIDENTE',
                'color'       => '#44a6f4',
                'descripcion' => 'Accidente de trabajo (en vía pública)',
            ],
        ];
        
        
        foreach ($tipos as $nuevo) {
            \Cat\Models\TipoPresentismo::create($nuevo);
        }
    }
}
