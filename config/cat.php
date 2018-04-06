<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Datos propios de CAT
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */
    'presentismos' => [
        'equivalencia' => [
            'injustificado' => [
                'tardanza'   => 3,
                'fin_semana' => 2,
            ],
        
        ],
    ],
    /*
     * Cantidad de dias permitidos para cargar una fecha de contrato
     */
    'fecha_contrato_registro' => 90,
    'cant_dias_navegacion' => 5,
    
    /*
     * Dia del mes que el periodo inicia y termina
     */
    'periodo_comienzo' => 16,
    'periodo_fin' => 15,
    'cant_dias' => 30,

    /*
     * Monto del contrato por defecto
     */
    'monto_contrato' => 16002
];
