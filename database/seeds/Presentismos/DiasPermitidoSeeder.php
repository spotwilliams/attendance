<?php
namespace Cat\Database\Presentismos;

use Cat\Models\DiaPermitido;
use Cat\Models\TipoPresentismo;
use Illuminate\Database\Seeder;

class DiasPermitidosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        $tPre = [
            'MEDICO'                 => [
                'cant_semanal'    => [
                    'JULY'      => 45,
                    'AUGUST'    => 19,
                    'SEPTEMBER' => 15,
                    'OCTOBER'   => 11,
                    'NOVEMBER'  => 8,
                    'DECEMBER'  => 4,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 13,
                    'AUGUST'    => 5,
                    'SEPTEMBER' => 4,
                    'OCTOBER'   => 3,
                    'NOVEMBER'  => 2,
                    'DECEMBER'  => 1,
                ],
            ],
            'EXAMEN'                 => [
                'cant_semanal'    => [
                    'JULY'      => 18,
                    'AUGUST'    => 8,
                    'SEPTEMBER' => 6,
                    'OCTOBER'   => 5,
                    'NOVEMBER'  => 3,
                    'DECEMBER'  => 2,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 5,
                    'AUGUST'    => 2,
                    'SEPTEMBER' => 2,
                    'OCTOBER'   => 1,
                    'NOVEMBER'  => 1,
                    'DECEMBER'  => 0,
                ],
            ],
            'FRANQUICIA'             => [
                'cant_semanal'    => [
                    'JULY'      => 14,
                    'AUGUST'    => 8,
                    'SEPTEMBER' => 6,
                    'OCTOBER'   => 5,
                    'NOVEMBER'  => 3,
                    'DECEMBER'  => 2,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 4,
                    'AUGUST'    => 2,
                    'SEPTEMBER' => 2,
                    'OCTOBER'   => 1,
                    'NOVEMBER'  => 1,
                    'DECEMBER'  => 0,
                ],
            ],
            'MATRIMONIO'             => [
                'cant_semanal'    => [
                    'JULY'      => 10,
                    'AUGUST'    => 10,
                    'SEPTEMBER' => 10,
                    'OCTOBER'   => 10,
                    'NOVEMBER'  => 10,
                    'DECEMBER'  => 10,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 10,
                    'AUGUST'    => 10,
                    'SEPTEMBER' => 10,
                    'OCTOBER'   => 10,
                    'NOVEMBER'  => 10,
                    'DECEMBER'  => 10,
                ],
            ],
            'DONACION_SANGRE'        => [
                'cant_semanal'    => [
                    'JULY'      => 1,
                    'AUGUST'    => 1,
                    'SEPTEMBER' => 1,
                    'OCTOBER'   => 1,
                    'NOVEMBER'  => 1,
                    'DECEMBER'  => 1,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 1,
                    'AUGUST'    => 1,
                    'SEPTEMBER' => 1,
                    'OCTOBER'   => 1,
                    'NOVEMBER'  => 1,
                    'DECEMBER'  => 1,
                ],
            ],
            'FALLECIMIENTO_FAMILIAR' => [
                'cant_semanal'    => [
                    'JULY'      => 5,
                    'AUGUST'    => 5,
                    'SEPTEMBER' => 5,
                    'OCTOBER'   => 5,
                    'NOVEMBER'  => 5,
                    'DECEMBER'  => 5,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 5,
                    'AUGUST'    => 5,
                    'SEPTEMBER' => 5,
                    'OCTOBER'   => 5,
                    'NOVEMBER'  => 5,
                    'DECEMBER'  => 5,
                ],
            ],
            'PREVENCION'             => [
                'cant_semanal'    => [
                    'JULY'      => 1,
                    'AUGUST'    => 1,
                    'SEPTEMBER' => 1,
                    'OCTOBER'   => 1,
                    'NOVEMBER'  => 1,
                    'DECEMBER'  => 1,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 1,
                    'AUGUST'    => 1,
                    'SEPTEMBER' => 1,
                    'OCTOBER'   => 1,
                    'NOVEMBER'  => 1,
                    'DECEMBER'  => 1,
                ],
            ],
            'VIOLENCIA_GENERO'       => [
                'cant_semanal'    => [
                    'JULY'      => 20,
                    'AUGUST'    => 20,
                    'SEPTEMBER' => 20,
                    'OCTOBER'   => 20,
                    'NOVEMBER'  => 20,
                    'DECEMBER'  => 20,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 20,
                    'AUGUST'    => 20,
                    'SEPTEMBER' => 20,
                    'OCTOBER'   => 20,
                    'NOVEMBER'  => 20,
                    'DECEMBER'  => 20,
                ],
            ],
            'MATERNIDAD'             => [
                'cant_semanal'    => [
                    'JULY'      => 105,
                    'AUGUST'    => 105,
                    'SEPTEMBER' => 105,
                    'OCTOBER'   => 105,
                    'NOVEMBER'  => 105,
                    'DECEMBER'  => 105,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 105,
                    'AUGUST'    => 105,
                    'SEPTEMBER' => 105,
                    'OCTOBER'   => 105,
                    'NOVEMBER'  => 105,
                    'DECEMBER'  => 105,
                ],
            ],
            'MATERNIDAD_SIN_GOCE'    => [
                'cant_semanal'    => [
                    'JULY'      => 120,
                    'AUGUST'    => 120,
                    'SEPTEMBER' => 120,
                    'OCTOBER'   => 120,
                    'NOVEMBER'  => 120,
                    'DECEMBER'  => 120,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 120,
                    'AUGUST'    => 120,
                    'SEPTEMBER' => 120,
                    'OCTOBER'   => 120,
                    'NOVEMBER'  => 120,
                    'DECEMBER'  => 120,
                ],
            ],
            'ESCOLAR'                => [
                'cant_semanal'    => [
                    'JULY'      => 4,
                    'AUGUST'    => 4,
                    'SEPTEMBER' => 4,
                    'OCTOBER'   => 4,
                    'NOVEMBER'  => 4,
                    'DECEMBER'  => 4,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 4,
                    'AUGUST'    => 4,
                    'SEPTEMBER' => 4,
                    'OCTOBER'   => 4,
                    'NOVEMBER'  => 4,
                    'DECEMBER'  => 4,
                ],
            ],
            'PATERNIDAD'             => [
                'cant_semanal'    => [
                    'JULY'      => 10,
                    'AUGUST'    => 10,
                    'SEPTEMBER' => 10,
                    'OCTOBER'   => 10,
                    'NOVEMBER'  => 10,
                    'DECEMBER'  => 10,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 10,
                    'AUGUST'    => 10,
                    'SEPTEMBER' => 10,
                    'OCTOBER'   => 10,
                    'NOVEMBER'  => 10,
                    'DECEMBER'  => 10,
                ],
            ],
            'MUDANZA'                => [
                'cant_semanal'    => [
                    'JULY'      => 1,
                    'AUGUST'    => 1,
                    'SEPTEMBER' => 1,
                    'OCTOBER'   => 1,
                    'NOVEMBER'  => 1,
                    'DECEMBER'  => 1,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 1,
                    'AUGUST'    => 1,
                    'SEPTEMBER' => 1,
                    'OCTOBER'   => 1,
                    'NOVEMBER'  => 1,
                    'DECEMBER'  => 1,
                ],
            ],
            'ACCIDENTE'              => [
                'cant_semanal'    => [
                    'JULY'      => -1,
                    'AUGUST'    => -1,
                    'SEPTEMBER' => -1,
                    'OCTOBER'   => -1,
                    'NOVEMBER'  => -1,
                    'DECEMBER'  => -1,
                ],
                'cant_fin_semana' => [
                    'JULY'      => -1,
                    'AUGUST'    => -1,
                    'SEPTEMBER' => -1,
                    'OCTOBER'   => -1,
                    'NOVEMBER'  => -1,
                    'DECEMBER'  => -1,
                ],
            ],
        ];
        
        foreach ($tPre as $tp => $cant) {
            $tipo  = TipoPresentismo::where('codigo', '=', $tp)->firstOrFail();
            $meses = ['JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER',];
            
            foreach ($meses as $mes) {
                DiaPermitido::create([
                    'cant_semanal'        => $cant['cant_semanal'][$mes],
                    'cant_fin_semana'     => $cant['cant_fin_semana'][$mes],
                    'id_tipo_presentismo' => $tipo->id,
                    'mes_ingreso'         => $mes,
                ]);
            }
        }
    }
    
}
