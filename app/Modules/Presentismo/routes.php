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
    }
);
