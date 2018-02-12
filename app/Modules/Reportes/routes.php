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
use Cat\Modules\Reportes\Controllers\Haberes\Estado\General as HaberesEstado;
use Cat\Modules\Reportes\Controllers\Haberes\Estado\Exportar as HaberesEstadoExport;
use Cat\Modules\Reportes\Controllers\Haberes\Agentes\General as HaberesAgentes;
use Cat\Modules\Reportes\Controllers\Haberes\Agentes\Exportar as HaberesAgentesExport;
use Cat\Modules\Reportes\Controllers\Haberes\VistaPrevia\General as HaberesVistaPrevia;
use Cat\Modules\Reportes\Controllers\Haberes\VistaPrevia\Exportar as HaberesVistaPreviaExport;

Route::group([
    'middleware' => ['web'],
    'prefix'     => 'reportes',
], function () {
    
    /**
     * Agentes
     */
    Route::group(['prefix' => 'agentes'], function () {
        
        Route::group(['prefix' => 'general'], function () {
            
            
            Route::get('/', AgentesGeneral::class . '@index')
                ->name('reportesAgentesGeneralIndex');
            
            Route::post('/', AgentesGeneral::class . '@search')
                ->name('reportesAgentesGeneralSearch');
            
            Route::post('export', AgentesExport::class . '@export')
                ->name('reportesAgentesGeneralExport');
        });
    });
    
    /**
     * Presentismos
     */
    Route::group(['prefix' => 'presentismo'], function () {
        
        Route::group(['prefix' => 'general'], function () {
            
            Route::get('/', PresentismosGeneral::class . '@index')
                ->name('reportesPresentismoGeneralIndex');
            
            Route::post('/', PresentismosGeneral::class . '@search')
                ->name('reportesPresentismoGeneralSearch');
            
            Route::post('export', PresentismoExport::class . '@export')
                ->name('reportesPresentismoGeneralExport');
        });
    });
    
    /**
     * Individuales
     */
    Route::group(['prefix' => 'individual'], function () {
        
        // Muestra el index
        Route::get('/', PresentismosIndividualSearch::class . '@index')
            ->name('reportesPresentismoIndividualIndex');
        
        // Busca
        Route::post('search/agente',
            PresentismosIndividualSearch::class . '@search')
            ->name('reportesPresentismoIndividualSearch');
        
        // Reporte
        Route::post('individual/search/presentismo',
            PresentismosIndividual::class . '@reporte')
            ->name('reportesPresentismoIndividualReportePresentismos');
    
        // Ajax
        Route::post('individual/search/presentismo/calendar',
            PresentismosIndividual::class . '@presentismosFecha')
            ->name('reportesPresentismoIndividualPresentismosFecha');
    
    
    
        // Descarga
        Route::post('export', PresentismosIndividual::class . '@export')
            ->name('reportesPresentismoIndividualExport');
    });
    
    
    /**
     * Haberes
     */
    Route::group(['prefix' => 'haberes'], function () {
        
        Route::group(['prefix' => 'estado'], function () {
            
            Route::get('/', HaberesEstado::class . '@index')
                ->name('reportesHaberesEstadoIndex');
            
            Route::post('/', HaberesEstado::class . '@search')
                ->name('reportesHaberesEstadoSearch');
            
            Route::post('export', HaberesEstadoExport::class . '@export')
                ->name('reportesHaberesEstadoExport');
        });
        
        Route::group(['prefix' => 'agentes'], function () {
            
            Route::get('/', HaberesAgentes::class . '@index')
                ->name('reportesHaberesAgentesIndex');
            
            Route::post('/', HaberesAgentes::class . '@search')
                ->name('reportesHaberesAgentesSearch');
            
            Route::post('export', HaberesAgentesExport::class . '@export')
                ->name('reportesHaberesAgentesExport');
        });
        
        Route::group(['prefix' => 'vista-previa'], function () {
            Route::get('/', HaberesVistaPrevia::class . '@index')
                ->name('reportesHaberesVistaPreviaIndex');
            
            Route::post('/', HaberesVistaPrevia::class . '@search')
                ->name('reportesHaberesVistaPreviaSearch');
            
            Route::post('export', HaberesVistaPreviaExport::class . '@export')
                ->name('reportesHaberesVistaPreviaExport');
        });
    });
}
);
