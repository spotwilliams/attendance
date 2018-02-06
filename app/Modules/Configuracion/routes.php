<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'configuracion', 'middleware' => ['web']], function () {
    
    Route::resource('base', \Cat\Modules\Configuracion\Bases\Controllers\CrudController::class);
    Route::resource('area', \Cat\Modules\Configuracion\Areas\Controllers\CrudController::class);
    Route::resource('turno', \Cat\Modules\Configuracion\Turnos\Controllers\CrudController::class);
    Route::resource('licencia', \Cat\Modules\Configuracion\TipoPresentismos\Controllers\CrudController::class);

    
    /**
     * Deletes
     */
    
    Route::get('base/delete/id/{id}', \Cat\Modules\Configuracion\Bases\Controllers\CrudController::class.'@delete')->name('configuracion.base.delete');
    Route::get('area/delete/id/{id}', \Cat\Modules\Configuracion\Areas\Controllers\CrudController::class.'@delete')->name('configuracion.area.delete');
    Route::get('turno/delete/id/{id}', \Cat\Modules\Configuracion\Turnos\Controllers\CrudController::class.'@delete')->name('configuracion.turno.delete');
    Route::get('licencia/delete/id/{id}', \Cat\Modules\Configuracion\TipoPresentismos\Controllers\CrudController::class.'@delete')->name('configuracion.licencia.delete');
    
});
