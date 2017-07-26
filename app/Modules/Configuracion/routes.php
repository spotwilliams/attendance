<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'configuracion'], function () {
    
    Route::resource('base', \Cat\Modules\Configuracion\Bases\Controllers\CrudController::class);
});
