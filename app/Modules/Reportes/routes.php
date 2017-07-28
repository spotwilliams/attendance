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
use Cat\Modules\Reportes\Controllers\Presentismos\General as PresentismosGeneral;
use Cat\Modules\Reportes\Controllers\Presentismos\Exportar as PresentismoExport;
use Cat\Modules\Reportes\Controllers\Agentes\General as AgentesGeneral;
use Cat\Modules\Reportes\Controllers\Agentes\Exportar as AgentesExport;

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
        
        Route::post('reportes/agentes/general/export', AgentesExport::class . '@export')
            ->name('reportesAgentesGeneralExport');
        
        /**
         * Presentismos
         */
        Route::get('reportes/presentismo/general', PresentismosGeneral::class . '@index')
            ->name('reportesPresentismoGeneralIndex');
        
        Route::post('reportes/presentismo/general', PresentismosGeneral::class . '@search')
            ->name('reportesPresentismoGeneralSearch');
        
        Route::post('reportes/presentismo/general/export', PresentismoExport::class . '@export')
            ->name('reportesPresentismoGeneralExport');
        
    }
);
