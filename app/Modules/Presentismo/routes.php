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

Route::group(
    ['middleware' => ['web']],
    function () {
        Route::get('presentismo/base/{base}', RegistroController::class . '@index')
            ->name('presentismoIndex');
        
        Route::post('presentismo/store', RegistroController::class . '@store')
            ->name('presentismoStore');
    
        Route::post('presentismo/lista/agentes/', RegistroController::class . '@prepareListaAgentes')
            ->name('presentismoPrepareListaAgentes');

        Route::get('presentismo/lista/agentes/base/{base}', RegistroController::class . '@listaAgentes')
            ->name('presentismoListaAgentes');

        Route::post('presentismo/store/comentario', RegistroController::class . '@comentario')
            ->name('presentismoComment');
    }
);
