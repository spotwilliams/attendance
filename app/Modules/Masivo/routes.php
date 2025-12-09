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
use Cat\Modules\Masivo\Controllers\Agentes\Registro as AgentesMasivoController;
use Cat\Modules\Masivo\Controllers\Presentismos\Registro as PresentismosMasivoController;
use Cat\Modules\Masivo\Controllers\Inicial\Registro as InicialMasivoController;

Route::group(
    ['middleware' => ['web']],
    function () {
        
        /**
         * Agentes
         */
        Route::get('agentes/masivo', AgentesMasivoController::class . '@index')
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
        Route::get('presentismo/masivo/select/params', PresentismosMasivoController::class . '@index')
            ->name('presentismosMasivoIndex');
        
        Route::post('presentismo/masivo/select/file', PresentismosMasivoController::class . '@selectFile')
            ->name('presentismosMasivoSelectFile');
        
        Route::post('presentismo/masivo/upload', PresentismosMasivoController::class . '@upload')
            ->name('presentismosMasivoUpload');
        
        Route::post('presentismo/masivo/download/errores', PresentismosMasivoController::class . '@downloadErrores')
            ->name('presentismosMasivoDownload');
        
        Route::get('presentismo/masivo/download/template/file/{fileName}',
            PresentismosMasivoController::class . '@downloadTemplate')
            ->name('presentismosMasivoTemplate');
    
    }
);
