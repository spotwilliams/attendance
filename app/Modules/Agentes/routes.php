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

Route::group(
    ['middleware' => ['web']],
    function () {
        Route::get('agentes/base/{base}', RegistroController::class . '@index')
            ->name('agentesIndex');
        
        Route::post('agentes/table/base/{base}', RegistroController::class . '@table')
            ->name('agentesTable');
        
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
        
        
        Route::get('agentes/edit/id/{id}', RegistroController::class . '@edit')
            ->name('agentesEdit');
        
        Route::get('agentes/delete/id/{id}', RegistroController::class . '@delete')
            ->name('agentesDelete');
        
        
        /**
         * Show
         */
        Route::get('agentes/show/id/{id}', RegistroController::class . '@show')
            ->name('agentesShow');
    
    }
);
