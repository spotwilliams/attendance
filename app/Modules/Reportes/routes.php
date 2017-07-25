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
use Cat\Reportes\Controllers\Presentismos\General as PresentismosGeneral;
use Cat\Reportes\Controllers\Agentes\General as AgentesGeneral;

Route::group(
    ['middleware' => ['web']],
    function () {
        
        /**
         * Agentes
         */
        Route::get('reportes/agentes/general', AgentesGeneral::class . '@index')
            ->name('reportesAgentesGeneralIndex');
    
        Route::post('reportes/agentes/general', AgentesGeneral::class . '@search')
            ->name('reportesAgentesGeneralSearch');
        
        /**
         * Presentismos
         */
        Route::get('reportes/presentismo/general', PresentismosGeneral::class . '@index')
            ->name('reportesPresentismoGeneralIndex');
        
        Route::post('reportes/presentismo/general', PresentismosGeneral::class . '@search')
            ->name('reportesPresentismoGeneralSearch');
        
    }
);
