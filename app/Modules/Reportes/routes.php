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
use Cat\Modules\Reportes\Controllers\Presentismos\Individual as PresentismosIndividual;
use Cat\Modules\Reportes\Controllers\Presentismos\IndividualSearch as PresentismosIndividualSearch;
use Cat\Modules\Reportes\Controllers\Presentismos\Exportar as PresentismoExport;
use Cat\Modules\Reportes\Controllers\Agentes\General as AgentesGeneral;
use Cat\Modules\Reportes\Controllers\Agentes\Exportar as AgentesExport;
use Cat\Modules\Reportes\Controllers\Haberes\General as HaberesGeneral;
use Cat\Modules\Reportes\Controllers\Haberes\Exportar as HaberesExport;

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
        /**
         * Individuales
         */
        // Muestra el index
        Route::get('reportes/presentismo/individual', PresentismosIndividualSearch::class . '@index')
            ->name('reportesPresentismoIndividualIndex');
    
        // Busca
        Route::post('reportes/presentismo/individual/search/agente', PresentismosIndividualSearch::class . '@search')
            ->name('reportesPresentismoIndividualSearch');

        // Reporte
        Route::post('reportes/presentismo/individual/search/presentismo', PresentismosIndividual::class . '@reporte')
            ->name('reportesPresentismoIndividualReportePresentismos');
    
        // Descarga
        Route::post('reportes/presentismo/individual/export', PresentismosIndividual::class . '@export')
            ->name('reportesPresentismoIndividualExport');

        /**
         * Haberes
         */
        Route::get('reportes/haberes/general', HaberesGeneral::class . '@index')
            ->name('reportesHaberesGeneralIndex');
        
        Route::post('reportes/haberes/general', HaberesGeneral::class . '@search')
            ->name('reportesHaberesGeneralSearch');
        
        Route::post('reportes/haberes/general/export', HaberesExport::class . '@export')
            ->name('reportesHaberesGeneralExport');
    }
);
