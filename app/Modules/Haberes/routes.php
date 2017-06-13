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
Route::group(
    ['middleware' => ['web'], 'prefix' => 'administracion'],
    
    function () {
        /**
         * Generales
         */
        Route::get('haberes/select/base/{base}', GeneralController::class . '@selectBase')
            ->name('haberesSelectBase');
        
        Route::post('haberes/select/periodo', GeneralController::class . '@selectPeriodo')
            ->name('haberesSelectPeriodo');
        
        Route::post('haberes/lista/agentes', GeneralController::class . '@prepareListaAgentes')
            ->name('haberesPrepareListaAgentes');
        
        Route::get('haberes/lista/agentes/base/{base}/periodo/{periodo}', GeneralController::class . '@listaAgentes')
            ->name('haberesListaAgentes');

        /**
         * Confirmaciones
         */
        Route::post('haberes/confirmar/single', ConfirmarController::class . '@single')
            ->name('haberesConfirmarSingle');

        Route::post('haberes/confirmar/lote', ConfirmarController::class . '@batch')
            ->name('haberesConfirmarLote');
        
    }
);
