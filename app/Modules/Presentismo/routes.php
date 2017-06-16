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
use Cat\Modules\Presentismo\Controllers\Registro\RegistroController;
use Cat\Modules\Presentismo\Controllers\Registro\GeneralController;

Route::group(
    ['middleware' => ['web']],
    function () {
        /**
         * General
         */
        Route::get('presentismo', GeneralController::class . '@index')
            ->name('presentismoIndex');
        
        Route::post('presentismo/lista/agentes/', GeneralController::class . '@prepareListaAgentes')
            ->name('presentismoPrepareListaAgentes');
        
        Route::get('presentismo/lista/agentes/base/{base}/desde/{desde}/hasta/{hasta}',
            GeneralController::class . '@listaAgentes')
            ->name('presentismoListaAgentes');
        
        /**
         * Stores
         */
        Route::post('presentismo/store', RegistroController::class . '@store')
            ->name('presentismoStore');
        
        Route::post('presentismo/store/comentario', RegistroController::class . '@comentario')
            ->name('presentismoComment');
        
        Route::post('presentismo/update/justificar', RegistroController::class . '@justificar')
            ->name('presentismoJustificar');
        Route::post('presentismo/update/injustificar', RegistroController::class . '@injustificar')
            ->name('presentismoInjustificar');
    }
);
