<?php


use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web'], 'prefix' => 'administracion'], function () {
    /**
     * Registro de facturas
     */
    Route::group(['prefix' => 'facturas'], function () {
        
        // Paso 1
        Route::get('index', \Cat\Modules\Haberes\Controllers\GeneralController::class . '@index')
            ->name('haberesIndex');
        
        // Paso 3
        Route::post('calcular', Cat\Modules\Haberes\Controllers\Registro\ConfirmarController::class . '@calcular')
            ->name('haberesCalcular');
        // Paso 4
        Route::post('registrar',
            Cat\Modules\Haberes\Controllers\Registro\ConfirmarController::class . '@registarFactura')
            ->name('haberesRegistrarFactura');
        
        Route::group(['prefix' => 'search'], function () {
            
            // Paso 2
            Route::post('/', Cat\Modules\Haberes\Controllers\GeneralController::class . '@search')
                ->name('haberesSearch');
            // Paso 2.1
            Route::post('by/agente', Cat\Modules\Haberes\Controllers\Registro\ByAgenteController::class . '@search')
                ->name('haberesSearchByAgente');
            
            // Paso 2.2
            Route::post('by/filtros', Cat\Modules\Haberes\Controllers\Registro\ByFiltrosController::class . '@search')
                ->name('haberesSearchByFiltros');
            
        });
        
    });
    
    Route::group(['prefix' => 'notificacion'], function () {
        
        // Paso 1
        Route::get('index', \Cat\Modules\Haberes\Controllers\Notificacion\NotificacionController::class . '@index')
            ->name('notificacionIndex');
        
        // Paso 3
        Route::post('calcular', Cat\Modules\Haberes\Controllers\Notificacion\ConfirmarController::class . '@calcular')
            ->name('notificacionCalcular');
        
        // Paso 4
        Route::group(['prefix' => 'notificar'], function () {
            Route::group(['prefix' => 'regular'], function () {
                
                // Paso 4.1
                Route::post('confirmar',
                    Cat\Modules\Haberes\Controllers\Notificacion\ConfirmarController::class . '@regular')
                    ->name('confirmarNotificacionRegular');
                // Paso 4.1
                Route::post('enviar',
                    Cat\Modules\Haberes\Controllers\Notificacion\NotificacionController::class . '@sendRegular')
                    ->name('enviarNotificacionRegular');
            });
            
            Route::group(['prefix' => 'libre'], function () {
                
                // Paso 4.1
                Route::post('confirmar',
                    Cat\Modules\Haberes\Controllers\Notificacion\ConfirmarController::class . '@libre')
                    ->name('notificacionLibre');
                // Paso 4.1
                Route::post('enviar',
                    Cat\Modules\Haberes\Controllers\Notificacion\NotificacionController::class . '@sendLibre')
                    ->name('enviarNotificacionLibre');
            });
            
        });
        
        Route::group(['prefix' => 'search'], function () {
            
            // Paso 2
            Route::post('/', \Cat\Modules\Haberes\Controllers\Notificacion\NotificacionController::class . '@search')
                ->name('notificacionSearch');
            // Paso 2.1
            Route::post('by/agente', Cat\Modules\Haberes\Controllers\Notificacion\ByAgenteController::class . '@search')
                ->name('notificacionSearchByAgente');
            
            // Paso 2.2
            Route::post('by/filtros',
                Cat\Modules\Haberes\Controllers\Notificacion\ByFiltrosController::class . '@search')
                ->name('notificacionSearchByFiltros');
            
        });
        
    });
//        /**
//         * Reporte
//         */
//        Route::group(['prefix' => 'reporte'], function () {
//
//            Route::post('/', ReporteController::class . '@reporte')
//                ->name('haberesReporte');
//
//            Route::post('preliminar', ReporteController::class . '@reportePreliminar')
//                ->name('haberesReportePreliminar');
//
//        });
    
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
