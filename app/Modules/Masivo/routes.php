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
use Cat\Masivo\Controllers\Inicial\Registro as InicialMasivoController;

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
        
        /**
         * Incial temporal

        Route::get('presentismo/inicial/masivo/select/params', InicialMasivoController::class . '@index')
            ->name('presentismosInicialMasivoIndex');
        
        Route::post('presentismo/inicial/masivo/select/file', InicialMasivoController::class . '@selectFile')
            ->name('presentismosInicialMasivoSelectFile');
        
        Route::post('presentismo/inicial/masivo/upload', InicialMasivoController::class . '@upload')
            ->name('presentismosInicialMasivoUpload');
        
        Route::post('presentismo/inicial/masivo/download/errores', InicialMasivoController::class . '@downloadErrores')
            ->name('presentismosInicialMasivoDownload');
        
        Route::get('presentismo/inicial/masivo/download/template/file/{fileName}',
            InicialMasivoController::class . '@downloadTemplate')
            ->name('presentismosInicialMasivoTemplate');
         */
    
        /**
         *
         * Update Agentes
         *
         */
    
        Route::get('agentes/masivo/update', \Cat\Masivo\Controllers\Agentes\Modificacion::class . '@index')
            ->name('agentesMasivoIndex');
    
        Route::post('agentes/masivo/update/upload', \Cat\Masivo\Controllers\Agentes\Modificacion::class . '@upload')
            ->name('agentesMasivoUpload');
    
        Route::post('agentes/masivo/update/download/errores', \Cat\Masivo\Controllers\Agentes\Modificacion::class . '@downloadErrores')
            ->name('agentesMasivoDownload');
    
        Route::get('agentes/masivo/update/download/template', \Cat\Masivo\Controllers\Agentes\Modificacion::class . '@downloadTemplate')
            ->name('agentesMasivoTemplate');
    }
);
