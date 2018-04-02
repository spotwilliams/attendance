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
use Cat\Modules\Haberes\Controllers\Registro\GeneralController;
use Cat\Modules\Haberes\Controllers\Registro\ConfirmarController;
use Cat\Modules\Haberes\Controllers\Registro\ReporteController;
use Cat\Modules\Haberes\Controllers\Registro\NotificacionController;

Route::group(['middleware' => ['web'], 'prefix' => 'administracion'], function () {
    /**
     * Generales
     */
    
    
    Route::get('index', GeneralController::class . '@index')
        ->name('haberesSelectBase');
    
    Route::group(['prefix' => 'haberes'], function () {
        
        
        Route::post('lista/agentes', GeneralController::class . '@listaAgentes')
            ->name('haberesListaAgentes');
        
        /**
         * Confirmaciones
         */
        Route::group(['prefix' => 'confirmar'], function () {
            
            Route::post('disclaimer', ConfirmarController::class . '@disclaimer')
                ->name('haberesConfirmarDisclaimer');
            
            Route::post('lote', ConfirmarController::class . '@batch')
                ->name('haberesConfirmarLote');
        });
        
        /**
         * Reporte
         */
        Route::group(['prefix' => 'reporte'], function () {
            
            Route::post('/', ReporteController::class . '@reporte')
                ->name('haberesReporte');
            
            Route::post('preliminar', ReporteController::class . '@reportePreliminar')
                ->name('haberesReportePreliminar');
            
        });
        
        
        /**
         * Notificacion
         */
        Route::group(['prefix' => 'reporte'], function () {
            
            Route::post('/', NotificacionController::class . '@send')
                ->name('haberesNotificar');
        });
        
        
    });
    
    /**
     * Modificacion Masivo
     */
    Route::group(['prefix' => 'modicacion'], function () {
        Route::group(['prefix' => 'masivo'], function () {
            
            Route::get('contrato',
                \Cat\Modules\Haberes\Controllers\Modificador\ContratosController::class . '@index')
                ->name('modificacionMasivaContratosIndex');
            
            Route::post('disclosure',
                \Cat\Modules\Haberes\Controllers\Modificador\ContratosController::class . '@disclosure')
                ->name('modificacionMasivaContratosDisclosure');

            Route::post('contrato',
                \Cat\Modules\Haberes\Controllers\Modificador\ContratosController::class . '@update')
                ->name('modificacionMasivaContratosUpdate');
        });
    });
    
    
});
