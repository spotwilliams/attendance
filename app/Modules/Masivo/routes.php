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
    
        Route::post('agentes/masivo/upload', RegistroMasivoController::class . '@upload')
            ->name('agentesMasivoUpload');
    
        Route::post('agentes/masivo/download/errores', RegistroMasivoController::class . '@downloadErrores')
            ->name('agentesMasivoDownload');
    }
);
