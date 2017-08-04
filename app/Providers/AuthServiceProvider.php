<?php

namespace Cat\Providers;

// Crud Agentes
use Cat\Modules\Agentes\Controllers\Registro\BusquedaController;
use Cat\Modules\Agentes\Controllers\Registro\LaboralesController;
use Cat\Modules\Agentes\Controllers\Registro\OperativosController;
use Cat\Modules\Agentes\Controllers\Registro\PersonalesController;
use Cat\Policies\Agentes\SearchAgentePolicy;

// Crud Policies
use Cat\Policies\Agentes\CrudLaboralesPolicy;
use Cat\Policies\Agentes\CrudOperativosPolicy;
use Cat\Policies\Agentes\CrudPersonalesPolicy;
use Cat\Modules\Agentes\Controllers\Registro\RegistroController as AgentesGeneral;
use Cat\Policies\Agentes\GeneralPolicy;

// Masivos - Agente
use Cat\Masivo\Controllers\Agentes\Registro as AgenteMasivo;
use Cat\Policies\Masivo\AgentesPolicy as AgenteMasivoPolicy;

// Masivos - presentismo
use Cat\Masivo\Controllers\Presentismos\Registro as PresentismoMasivo;
use Cat\Policies\Agentes\PresentismosPolicy as PresentismoMasivoPolicy;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies
        = [
            BusquedaController::class   => SearchAgentePolicy::class,
            LaboralesController::class  => CrudLaboralesPolicy::class,
            OperativosController::class => CrudOperativosPolicy::class,
            PersonalesController::class => CrudPersonalesPolicy::class,
            AgentesGeneral::class       => GeneralPolicy::class,
            AgenteMasivo::class         => AgenteMasivoPolicy::class,
            PresentismoMasivo::class    => PresentismoMasivoPolicy::class,
        ];
    
    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        
    }
}
