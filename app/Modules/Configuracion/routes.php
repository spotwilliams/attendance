<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'configuracion', 'middleware' => ['web']], function () {
    
    Route::resource('base', \Cat\Modules\Configuracion\Bases\Controllers\CrudController::class);
    Route::resource('area', \Cat\Modules\Configuracion\Areas\Controllers\CrudController::class);
    Route::resource('turno', \Cat\Modules\Configuracion\Turnos\Controllers\CrudController::class);
    
//    Route::resource('licencia', \Cat\Modules\Configuracion\TipoPresentismos\Controllers\CrudController::class);

});
