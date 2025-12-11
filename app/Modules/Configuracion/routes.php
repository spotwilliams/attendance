<?php

use Illuminate\Support\Facades\Route;

Route::name('configuracion.')
    ->prefix('configuracion')
    ->middleware('web')
    ->group(function (): void {

        Route::resource('base', \Cat\Modules\Configuracion\Bases\Controllers\CrudController::class);
        Route::resource('area', \Cat\Modules\Configuracion\Areas\Controllers\CrudController::class);
        Route::resource('turno', \Cat\Modules\Configuracion\Turnos\Controllers\CrudController::class);
        Route::resource('licencia', \Cat\Modules\Configuracion\TipoPresentismos\Controllers\CrudController::class);

    });

// Routes with custom names
Route::middleware('web')
    ->group(function () {

        /**
         * Deletes
         */

        Route::get('base/delete/id/{id}', \Cat\Modules\Configuracion\Bases\Controllers\CrudController::class . '@delete')->name('configuracion.base.delete');
        Route::get('area/delete/id/{id}', \Cat\Modules\Configuracion\Areas\Controllers\CrudController::class . '@delete')->name('configuracion.area.delete');
        Route::get('turno/delete/id/{id}', \Cat\Modules\Configuracion\Turnos\Controllers\CrudController::class . '@delete')->name('configuracion.turno.delete');
        Route::get('licencia/delete/id/{id}', \Cat\Modules\Configuracion\TipoPresentismos\Controllers\CrudController::class . '@delete')->name('configuracion.licencia.delete');

        Route::get('fecha/cierre', \Cat\Modules\Configuracion\FechaCierrePeriodo\Controllers\CrudController::class . '@index')
            ->name('configuracion.fecha.cierre.index');

        Route::post('fecha/cierre', \Cat\Modules\Configuracion\FechaCierrePeriodo\Controllers\CrudController::class . '@update')
            ->name('configuracion.fecha.cierre.update');

    });
