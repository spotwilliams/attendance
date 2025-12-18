<?php

namespace Database\Seeders\Presentismos;

use Cat\Models\DiaPermitido;
use Cat\Models\TipoPresentismo;
use Illuminate\Database\Seeder;

class DiasPermitidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        
        $tPre = [
            'MJ' => [
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
            
            'FRANQUICIA' => [
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
            'MA'         => [
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
            'RA'         => [
                'cant_semanal'    => [
                    'JULY'      => 30,
                    'AUGUST'    => 30,
                    'SEPTEMBER' => 30,
                    'OCTOBER'   => 30,
                    'NOVEMBER'  => 30,
                    'DECEMBER'  => 30,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 30,
                    'AUGUST'    => 30,
                    'SEPTEMBER' => 30,
                    'OCTOBER'   => 30,
                    'NOVEMBER'  => 30,
                    'DECEMBER'  => 30,
                ],
            ],
            'L'          => [
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
            'F/G'        => [
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
            'F/A'        => [
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
            'F/C'        => [
                'cant_semanal'    => [
                    'JULY'      => 3,
                    'AUGUST'    => 3,
                    'SEPTEMBER' => 3,
                    'OCTOBER'   => 3,
                    'NOVEMBER'  => 3,
                    'DECEMBER'  => 3,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 3,
                    'AUGUST'    => 3,
                    'SEPTEMBER' => 3,
                    'OCTOBER'   => 3,
                    'NOVEMBER'  => 3,
                    'DECEMBER'  => 3,
                ],
            ],
            'F/U'        => [
                'cant_semanal'    => [
                    'JULY'      => 3,
                    'AUGUST'    => 3,
                    'SEPTEMBER' => 3,
                    'OCTOBER'   => 3,
                    'NOVEMBER'  => 3,
                    'DECEMBER'  => 3,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 3,
                    'AUGUST'    => 3,
                    'SEPTEMBER' => 3,
                    'OCTOBER'   => 3,
                    'NOVEMBER'  => 3,
                    'DECEMBER'  => 3,
                ],
            ],
            'L/A'        => [
                'cant_semanal'    => [
                    'JULY'      => 90,
                    'AUGUST'    => 90,
                    'SEPTEMBER' => 90,
                    'OCTOBER'   => 90,
                    'NOVEMBER'  => 90,
                    'DECEMBER'  => 90,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 90,
                    'AUGUST'    => 90,
                    'SEPTEMBER' => 90,
                    'OCTOBER'   => 90,
                    'NOVEMBER'  => 90,
                    'DECEMBER'  => 90,
                ],
            ],
            'VG'         => [
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
            
            'EXMA' => [
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
            'AE'   => [
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
            
            'F/M'     => [
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
            'AT'      => [
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
            //
            'PN'      => [
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
            'PM'      => [
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
            'NN'      => [
                'cant_semanal'    => [
                    'JULY'      => 15,
                    'AUGUST'    => 15,
                    'SEPTEMBER' => 15,
                    'OCTOBER'   => 15,
                    'NOVEMBER'  => 15,
                    'DECEMBER'  => 15,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 15,
                    'AUGUST'    => 15,
                    'SEPTEMBER' => 15,
                    'OCTOBER'   => 15,
                    'NOVEMBER'  => 15,
                    'DECEMBER'  => 15,
                ],
            ],
            'NM'      => [
                'cant_semanal'    => [
                    'JULY'      => 15,
                    'AUGUST'    => 15,
                    'SEPTEMBER' => 15,
                    'OCTOBER'   => 15,
                    'NOVEMBER'  => 15,
                    'DECEMBER'  => 15,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 15,
                    'AUGUST'    => 15,
                    'SEPTEMBER' => 15,
                    'OCTOBER'   => 15,
                    'NOVEMBER'  => 15,
                    'DECEMBER'  => 15,
                ],
            ],
            'NE'      => [
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
            'AD'      => [
                'cant_semanal'    => [
                    'JULY'      => 90,
                    'AUGUST'    => 90,
                    'SEPTEMBER' => 90,
                    'OCTOBER'   => 90,
                    'NOVEMBER'  => 90,
                    'DECEMBER'  => 90,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 90,
                    'AUGUST'    => 90,
                    'SEPTEMBER' => 90,
                    'OCTOBER'   => 90,
                    'NOVEMBER'  => 90,
                    'DECEMBER'  => 90,
                ],
            ],
            'ADE'     => [
                'cant_semanal'    => [
                    'JULY'      => 30,
                    'AUGUST'    => 30,
                    'SEPTEMBER' => 30,
                    'OCTOBER'   => 30,
                    'NOVEMBER'  => 30,
                    'DECEMBER'  => 30,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 30,
                    'AUGUST'    => 30,
                    'SEPTEMBER' => 30,
                    'OCTOBER'   => 30,
                    'NOVEMBER'  => 30,
                    'DECEMBER'  => 30,
                ],
            ],
            'EXAD'    => [
                'cant_semanal'    => [
                    'JULY'      => 30,
                    'AUGUST'    => 30,
                    'SEPTEMBER' => 30,
                    'OCTOBER'   => 30,
                    'NOVEMBER'  => 30,
                    'DECEMBER'  => 30,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 30,
                    'AUGUST'    => 30,
                    'SEPTEMBER' => 30,
                    'OCTOBER'   => 30,
                    'NOVEMBER'  => 30,
                    'DECEMBER'  => 30,
                ],
            ],
            'ADN'     => [
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
            'C/M'     => [
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
            'A68'     => [
                'cant_semanal'    => [
                    'JULY'      => 45,
                    'AUGUST'    => 45,
                    'SEPTEMBER' => 45,
                    'OCTOBER'   => 45,
                    'NOVEMBER'  => 45,
                    'DECEMBER'  => 45,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 45,
                    'AUGUST'    => 45,
                    'SEPTEMBER' => 45,
                    'OCTOBER'   => 45,
                    'NOVEMBER'  => 45,
                    'DECEMBER'  => 45,
                ],
            ],
            'M'       => [
                'cant_semanal'    => [
                    'JULY'      => 45,
                    'AUGUST'    => 45,
                    'SEPTEMBER' => 45,
                    'OCTOBER'   => 45,
                    'NOVEMBER'  => 45,
                    'DECEMBER'  => 45,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 45,
                    'AUGUST'    => 45,
                    'SEPTEMBER' => 45,
                    'OCTOBER'   => 45,
                    'NOVEMBER'  => 45,
                    'DECEMBER'  => 45,
                ],
            ],
            'LEY 360' => [
                'cant_semanal'    => [
                    'JULY'      => 180,
                    'AUGUST'    => 180,
                    'SEPTEMBER' => 180,
                    'OCTOBER'   => 180,
                    'NOVEMBER'  => 180,
                    'DECEMBER'  => 180,
                ],
                'cant_fin_semana' => [
                    'JULY'      => 180,
                    'AUGUST'    => 180,
                    'SEPTEMBER' => 180,
                    'OCTOBER'   => 180,
                    'NOVEMBER'  => 180,
                    'DECEMBER'  => 180,
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
        $mesesPorTipo = [
            'LOCACION'          => [
                'D'  => [
                    'cant_semanal'    => [
                        'JULY'      => 2,
                        'AUGUST'    => 2,
                        'SEPTEMBER' => 2,
                        'OCTOBER'   => 2,
                        'NOVEMBER'  => 2,
                        'DECEMBER'  => 2,
                    ],
                    'cant_fin_semana' => [
                        'JULY'      => 2,
                        'AUGUST'    => 2,
                        'SEPTEMBER' => 2,
                        'OCTOBER'   => 2,
                        'NOVEMBER'  => 2,
                        'DECEMBER'  => 2,
                    ],
                ],
                'X'  => [
                    'cant_semanal'    => [
                        'JULY'      => 28,
                        'AUGUST'    => 28,
                        'SEPTEMBER' => 28,
                        'OCTOBER'   => 28,
                        'NOVEMBER'  => 28,
                        'DECEMBER'  => 28,
                    ],
                    'cant_fin_semana' => [
                        'JULY'      => 28,
                        'AUGUST'    => 28,
                        'SEPTEMBER' => 28,
                        'OCTOBER'   => 28,
                        'NOVEMBER'  => 28,
                        'DECEMBER'  => 28,
                    ],
                ],
                'N'  => [
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
                'MF' => [
                    'cant_semanal'    => [
                        'JULY'      => 15,
                        'AUGUST'    => 15,
                        'SEPTEMBER' => 15,
                        'OCTOBER'   => 15,
                        'NOVEMBER'  => 15,
                        'DECEMBER'  => 15,
                    ],
                    'cant_fin_semana' => [
                        'JULY'      => 15,
                        'AUGUST'    => 15,
                        'SEPTEMBER' => 15,
                        'OCTOBER'   => 15,
                        'NOVEMBER'  => 15,
                        'DECEMBER'  => 15,
                    ],
                ],
                
                'PA' => [
                    'cant_semanal'    => [
                        'JULY'      => 12,
                        'AUGUST'    => 12,
                        'SEPTEMBER' => 12,
                        'OCTOBER'   => 12,
                        'NOVEMBER'  => 12,
                        'DECEMBER'  => 12,
                    ],
                    'cant_fin_semana' => [
                        'JULY'      => 12,
                        'AUGUST'    => 12,
                        'SEPTEMBER' => 12,
                        'OCTOBER'   => 12,
                        'NOVEMBER'  => 12,
                        'DECEMBER'  => 12,
                    ],
                ],
            
            ],
            'SITUACION_REVISTA' => [
                'D'  => [
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
                'X'  => [
                    'cant_semanal'    => [
                        'JULY'      => 18,
                        'AUGUST'    => 18,
                        'SEPTEMBER' => 18,
                        'OCTOBER'   => 18,
                        'NOVEMBER'  => 18,
                        'DECEMBER'  => 18,
                    ],
                    'cant_fin_semana' => [
                        'JULY'      => 18,
                        'AUGUST'    => 18,
                        'SEPTEMBER' => 18,
                        'OCTOBER'   => 18,
                        'NOVEMBER'  => 18,
                        'DECEMBER'  => 18,
                    ],
                ],
                'N'  => [
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
                'MF' => [
                    'cant_semanal'    => [
                        'JULY'      => 45,
                        'AUGUST'    => 45,
                        'SEPTEMBER' => 45,
                        'OCTOBER'   => 45,
                        'NOVEMBER'  => 45,
                        'DECEMBER'  => 45,
                    ],
                    'cant_fin_semana' => [
                        'JULY'      => 45,
                        'AUGUST'    => 45,
                        'SEPTEMBER' => 45,
                        'OCTOBER'   => 45,
                        'NOVEMBER'  => 45,
                        'DECEMBER'  => 45,
                    ],
                ],
                
                'PA' => [
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
            ],
        ];
        foreach ($mesesPorTipo as $aplica => $tipos) {
            foreach ($tipos as $codigo => $cants) {
                $tipo = TipoPresentismo::where('codigo', '=', $codigo)
                    ->where('aplica', '=', $aplica)->firstOrFail();
                
                $meses = ['JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER',];
                
                foreach ($meses as $mes) {
                    DiaPermitido::create([
                        'cant_semanal'        => $cants['cant_semanal'][$mes],
                        'cant_fin_semana'     => $cants['cant_fin_semana'][$mes],
                        'id_tipo_presentismo' => $tipo->id,
                        'mes_ingreso'         => $mes,
                    ]);
                }
            }
        }
    }
    
}
