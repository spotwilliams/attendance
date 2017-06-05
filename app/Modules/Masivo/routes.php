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
use Cat\Masivo\Controllers\Agentes\Registro as RegistroMasivoController;

Route::group(
    ['middleware' => ['web']],
    function () {
        
        Route::get('agentes/masivo/base/{base}', RegistroMasivoController::class . '@index')
            ->name('agentesMasivoIndex');
        
        
    }
);
