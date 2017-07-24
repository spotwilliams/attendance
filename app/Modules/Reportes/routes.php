<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Rutas del presente modulo.
|
*/
use Illuminate\Support\Facades\Route;
use Cat\Reportes\Controllers\Presentismos\General;
Route::group(
    ['middleware' => ['web']],
    function () {
        
        /**
         * Agentes
         */
        
        /**
         * Presentismos
         */
        Route::get('reportes/presentismo/general', General::class . '@index')
            ->name('reportesPresentismoGeneralIndex');
        
        Route::post('reportes/presentismo/general', General::class . '@search')
            ->name('reportesPresentismoGeneralSeach');
        
        
    }
);
