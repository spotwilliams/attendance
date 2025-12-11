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
use Cat\Modules\Agentes\Controllers\Registro\RegistroController;
use Cat\Modules\Agentes\Controllers\Registro\PersonalesController;
use Cat\Modules\Agentes\Controllers\Registro\LaboralesController;
use Cat\Modules\Agentes\Controllers\Registro\OperativosController;
use Cat\Modules\Agentes\Controllers\Registro\BusquedaController;

Route::group(
    ['middleware' => ['web']],
    function (): void {
        /**
         * Generales
         */

        Route::get('agentes/base/{base}', RegistroController::class . '@index')
            ->name('agentesIndex');
        
        Route::get('agentes/show/id/{id}', RegistroController::class . '@show')
            ->name('agentesShow');
        
        /**
         * Creates
         */
        Route::get('agentes/create/personales', PersonalesController::class . '@create')
            ->name('agentesCreatePersonales');
        
        Route::get('agentes/create/laborales/id/{id}', LaboralesController::class . '@create')
            ->name('agentesCreateLaborales');
        
        Route::get('agentes/create/operativos/id/{id}', OperativosController::class . '@create')
            ->name('agentesCreateOperativos');
        
        /**
         * Stores
         */
        Route::post('agentes/store/personales', PersonalesController::class . '@store')
            ->name('agentesStorePersonales');
        
        Route::post('agentes/store/laborales', LaboralesController::class . '@store')
            ->name('agentesStoreLaborales');
        
        Route::post('agentes/store/operativos', OperativosController::class . '@store')
            ->name('agentesStoreOperativos');
        
        /**
         * Edit
         */
        
        Route::get('agentes/edit/personales/id/{id}', PersonalesController::class . '@edit')
            ->name('agentesEditPersonales');
        
        Route::get('agentes/edit/laborales/id/{id}', LaboralesController::class . '@edit')
            ->name('agentesEditLaborales');
        
        Route::get('agentes/edit/operativos/id/{id}', OperativosController::class . '@edit')
            ->name('agentesEditOperativos');
        
        /**
         * Update
         */
        Route::post('agentes/update/personales', PersonalesController::class . '@update')
            ->name('agentesUpdatePersonales');
        
        Route::post('agentes/update/laborales', LaboralesController::class . '@update')
            ->name('agentesUpdateLaborales');
        
        Route::post('agentes/update/operativos', OperativosController::class . '@update')
            ->name('agentesUpdateOperativos');
        
        /**
         * Delete
         */
//        Route::get('agentes/delete/id/{id}', RegistroController::class . '@delete')
//            ->name('agentesDelete');
//
//        Route::post('agentes/destroy/', RegistroController::class . '@destroy')
//            ->name('agentesDestroy');
//
        /**
         * Busquedas
         */
        Route::get('agentes/buscar/', BusquedaController::class . '@search')
            ->name('agentesSearchIndex');
    
    }
);
