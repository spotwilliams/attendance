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
use Cat\Modules\Haberes\Controllers\Registro\RegistroController;

Route::group(
    ['middleware' => ['web'], 'prefix' => 'administracion'],
    
    function () {
        Route::get('haberes/base/{base}', RegistroController::class . '@index')
            ->name('haberesIndex');
        
        Route::post('haberes/lista/agentes', RegistroController::class . '@prepareListaAgentes')
            ->name('haberesPrepareListaAgentes');
        
        Route::get('haberes/lista/agentes/base/{base}/periodo/{periodo}', RegistroController::class . '@listaAgentes')
            ->name('haberesListaAgentes');
        
        Route::post('haberes/table/base/{base}', RegistroController::class . '@table')
            ->name('haberesTable');
        
        Route::post('haberes/store/comentario', RegistroController::class . '@comentario')
            ->name('haberesComment');
    }
);
