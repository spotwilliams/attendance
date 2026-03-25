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
use Cat\Modules\Presentismo\Controllers\GeneralController;
use Cat\Modules\Presentismo\Controllers\Registro\JustificacionController;
use Cat\Modules\Presentismo\Controllers\PorAgenteController;
use Cat\Modules\Presentismo\Controllers\Registration\AttendanceController;
use Cat\Modules\Presentismo\Controllers\Registration\AttendanceStoreController;
use Cat\Modules\Presentismo\Controllers\Registration\AttendanceTypesController;
use Cat\Modules\Presentismo\Controllers\Registro\ComentarioController;

/*
|--------------------------------------------------------------------------
| Inertia Routes (new frontend)
|--------------------------------------------------------------------------
*/
Route::group(
    ['middleware' => ['web', 'auth'], 'prefix' => 'app'],
    function (): void {
        Route::get('attendance', AttendanceController::class)
            ->name('attendance.index');

        Route::post('attendance/store', AttendanceStoreController::class)
            ->name('attendance.store');

        Route::get('attendance/types/agent/{agent}/date/{date}', AttendanceTypesController::class)
            ->name('attendance.types');
    }
);

/*
|--------------------------------------------------------------------------
| Legacy Blade Routes
|--------------------------------------------------------------------------
*/
Route::group(
    ['middleware' => ['web']],
    function (): void {
        /**
         * General
         */
        Route::get('presentismo', GeneralController::class . '@index')
            ->name('presentismoIndex');
        
        Route::post('presentismo/lista/agentes/', GeneralController::class . '@prepareListaAgentes')
            ->name('presentismoPrepareListaAgentes');
    
        /**
         * Por agente
         */
        Route::get('presentismo/agente', PorAgenteController::class . '@index')
            ->name('presentismoPorAgenteIndex');

        Route::post('presentismo/agente/search', PorAgenteController::class . '@search')
            ->name('presentismoPorAgenteSearch');
    
        Route::post('presentismo/individual/agentes', PorAgenteController::class . '@prepareIndividualAgente')
            ->name('presentismoPorAgenteRegistro');
        /**
         * Stores
         */
        Route::post('presentismo/registro', RegistroController::class . '@registro')
            ->name('presentismoStore');
    
        /**
         * Comentarios
         */
        Route::get('presentismo/comentario/presentismo/{id}', ComentarioController::class . '@lista')
            ->name('presentismoCommentLista');
        Route::post('presentismo/store/comentario', ComentarioController::class . '@store')
            ->name('presentismoComment');
    
        Route::post('presentismo/update/justificar', JustificacionController::class . '@justificar')
            ->name('presentismoJustificar');
        Route::post('presentismo/update/injustificar', JustificacionController::class . '@injustificar')
            ->name('presentismoInjustificar');
    }
);
