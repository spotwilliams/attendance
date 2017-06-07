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
use Cat\Masivo\Controllers\Agentes\Registro as AgentesMasivoController;
use Cat\Masivo\Controllers\Presentismos\Registro as PresentismosMasivoController;

Route::group(
    ['middleware' => ['web']],
    function () {
    
        /**
         * Agentes
         */
        Route::get('agentes/masivo/base/{base}', AgentesMasivoController::class . '@index')
            ->name('agentesMasivoIndex');
    
        Route::post('agentes/masivo/upload', AgentesMasivoController::class . '@upload')
            ->name('agentesMasivoUpload');
    
        Route::post('agentes/masivo/download/errores', AgentesMasivoController::class . '@downloadErrores')
            ->name('agentesMasivoDownload');

        Route::get('agentes/masivo/download/template', AgentesMasivoController::class . '@downloadTemplate')
            ->name('agentesMasivoTemplate');
    
        /**
         * Presentismos
         */
        Route::get('presentismo/masivo/base/{base}', PresentismosMasivoController::class . '@index')
            ->name('presentismosMasivoIndex');
    
        Route::post('presentismo/masivo/upload', PresentismosMasivoController::class . '@upload')
            ->name('presentismosMasivoUpload');
    
        Route::post('presentismo/masivo/download/errores', PresentismosMasivoController::class . '@downloadErrores')
            ->name('presentismosMasivoDownload');
    
        Route::get('presentismo/masivo/download/template', PresentismosMasivoController::class . '@downloadTemplate')
            ->name('presentismosMasivoTemplate');
    }
);
