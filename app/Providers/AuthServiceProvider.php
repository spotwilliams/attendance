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

// Registro Presentismo
use Cat\Modules\Presentismo\Controllers\Registro\GeneralController as PresentismoGeneral;
use Cat\Policies\Presentismos\GeneralPolicy as PresentismoGeneralPolicy;
use Cat\Modules\Presentismo\Controllers\Registro\PorAgenteController as PresentismoPorAgente;
use Cat\Policies\Presentismos\PorAgentePolicy;
use Cat\Modules\Presentismo\Controllers\Registro\RegistroController as RegistroPresentismo;
use Cat\Policies\Presentismos\RegistroPolicy as RegistroPresentismoPolicy;
use Cat\Modules\Presentismo\Controllers\Registro\JustificacionController;
use Cat\Policies\Presentismos\JustificacionPolicy;

// Haberes
use Cat\Modules\Haberes\Controllers\Registro\GeneralController as HaberesGeneral;
use Cat\Policies\Haberes\GeneralPolicy as HaberesGeneralPolicy;
use Cat\Modules\Haberes\Controllers\Registro\ReporteController as HaberesReporte;
use Cat\Policies\Haberes\ReportePolicy as HaberesReportePolicy;
use Cat\Modules\Haberes\Controllers\Registro\ConfirmarController as HaberesConfirmar;
use Cat\Policies\Haberes\CierrePeriodoPolicy as HaberesConfirmarPolicy;

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
            BusquedaController::class      => SearchAgentePolicy::class,
            LaboralesController::class     => CrudLaboralesPolicy::class,
            OperativosController::class    => CrudOperativosPolicy::class,
            PersonalesController::class    => CrudPersonalesPolicy::class,
            AgentesGeneral::class          => GeneralPolicy::class,
            AgenteMasivo::class            => AgenteMasivoPolicy::class,
            PresentismoMasivo::class       => PresentismoMasivoPolicy::class,
            PresentismoGeneral::class      => PresentismoGeneralPolicy::class,
            PresentismoPorAgente::class    => PorAgentePolicy::class,
            RegistroPresentismo::class     => RegistroPresentismoPolicy::class,
            JustificacionController::class => JustificacionPolicy::class,
            HaberesGeneral::class          => HaberesGeneralPolicy::class,
            HaberesReporte::class          => HaberesReportePolicy::class,
            HaberesConfirmar::class        => HaberesConfirmarPolicy::class,
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
