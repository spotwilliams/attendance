<?php

namespace Cat\Providers;

// Crud Agentes
use Cat\Http\Controllers\HomeController;
use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Haberes\Controllers\GeneralController;
use Cat\Modules\Haberes\Controllers\Modificador\ContratosController;
use Cat\Modules\Haberes\Controllers\Notificacion\ByAgenteController;
use Cat\Modules\Haberes\Controllers\Notificacion\ByFiltrosController;
use Cat\Modules\Haberes\Controllers\Notificacion\ConfirmarController;
use Cat\Modules\Haberes\Controllers\Notificacion\NotificacionController;
use Cat\Modules\Reportes\Controllers\Haberes\VistaPrevia\General;
use Cat\Policies\DashboardPolicy;
use Cat\Policies\Haberes\ModificadorContratosPolicy;
use Cat\Policies\Haberes\NotificacionPolicy;
use Cat\Policies\Haberes\RegistroFacturacionPolicy;
use Cat\Policies\Reportes\Haberes\VistaPreviaReportePolicy;
use Cat\Policies\RequestGatePolicy;
use Cat\Policies\TipoPresentismoGatePolicy;
use Cat\User;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
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
use Cat\Modules\Haberes\Controllers\Registro\ReporteController as HaberesReporte;
use Cat\Policies\Haberes\ReportePolicy as HaberesReportePolicy;
use Cat\Modules\Haberes\Controllers\Registro\ConfirmarController as HaberesConfirmar;

// Reportes
use Cat\Modules\Reportes\Controllers\Agentes\General as ReporteAgentes;
use Cat\Modules\Reportes\Controllers\Agentes\Exportar as ExportarReporteAgentes;
use Cat\Modules\Reportes\Controllers\Presentismos\General as ReportePresentismos;
use Cat\Modules\Reportes\Controllers\Presentismos\Exportar as ExprotarReportePresentismos;
use Cat\Policies\Reportes\Agentes\ReportePolicy as AgentesReportePolicy;
use Cat\Policies\Reportes\Agentes\ExportarPolicy as AgentesExportarReportePolicy;
use Cat\Policies\Reportes\Presentismos\ReportePolicy as PresentismosReportePolicy;
use Cat\Policies\Reportes\Presentismos\ExportarPolicy as PresentismosExportarReportePolicy;
use Cat\Modules\Reportes\Controllers\Presentismos\Individual as ReporteIndividual;
use Cat\Modules\Reportes\Controllers\Presentismos\IndividualSearch as ReporteIndividualSearch;
use Cat\Policies\Reportes\Presentismos\IndividualPolicy;
// Reportes de Haberes
use Cat\Modules\Reportes\Controllers\Haberes\Estado\General as ReporteHaberes;
use Cat\Modules\Reportes\Controllers\Haberes\Estado\Exportar as ExportarHaberes;
use Cat\Modules\Reportes\Controllers\Haberes\Agentes\General as ReporteHaberesAgentes;
use Cat\Modules\Reportes\Controllers\Haberes\Agentes\Exportar as ExportarHaberesAgentes;
use Cat\Policies\Reportes\Haberes\ReportePolicy as ReportePolicyHaber;
use Cat\Policies\Reportes\Haberes\ExportarPolicy as ExportarPolicyHaber;
// Configuracion
use Cat\Modules\Configuracion\Areas\Controllers\CrudController as AreasCrud;
use Cat\Modules\Configuracion\Bases\Controllers\CrudController as BasesCrud;
use Cat\Modules\Configuracion\Turnos\Controllers\CrudController as TurnosCrud;
use Cat\Modules\Configuracion\TipoPresentismos\Controllers\CrudController as TipoPresentismosCrud;
use Cat\Policies\Configuracion\Areas\ConfiguracionPolicy;

// Seguridad
use Cat\Modules\Security\Controllers\PermissionCrudController;
use Cat\Modules\Security\Controllers\RoleCrudController;
use Cat\Modules\Security\Controllers\UserCrudController;
use Cat\Policies\RequestPolicy;
use Cat\Policies\Configuracion\Areas\ConfiguracionPermisosPolicy;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
            
            NotificacionController::class => NotificacionPolicy::class,
            ByAgenteController::class     => NotificacionPolicy::class,
            ByFiltrosController::class    => NotificacionPolicy::class,
            ConfirmarController::class    => NotificacionPolicy::class,
            
            GeneralController::class                                             => RegistroFacturacionPolicy::class,
            \Cat\Modules\Haberes\Controllers\Registro\ByAgenteController::class  => RegistroFacturacionPolicy::class,
            \Cat\Modules\Haberes\Controllers\Registro\ByFiltrosController::class => RegistroFacturacionPolicy::class,
            \Cat\Modules\Haberes\Controllers\Registro\ConfirmarController::class => RegistroFacturacionPolicy::class,
            
            HaberesReporte::class => HaberesReportePolicy::class,
            //reporte
            
            ContratosController::class => ModificadorContratosPolicy::class,
            
            ReporteAgentes::class      => AgentesReportePolicy::class,
            ReportePresentismos::class => PresentismosReportePolicy::class,
            
            ExportarReporteAgentes::class      => AgentesExportarReportePolicy::class,
            ExprotarReportePresentismos::class => PresentismosExportarReportePolicy::class,
            
            AreasCrud::class            => ConfiguracionPolicy::class,
            BasesCrud::class            => ConfiguracionPolicy::class,
            TurnosCrud::class           => ConfiguracionPolicy::class,
            TipoPresentismosCrud::class => ConfiguracionPolicy::class,
            
            PermissionCrudController::class => ConfiguracionPermisosPolicy::class,
            RoleCrudController::class       => ConfiguracionPermisosPolicy::class,
            UserCrudController::class       => ConfiguracionPermisosPolicy::class,
            
            ReporteIndividual::class       => IndividualPolicy::class,
            ReporteIndividualSearch::class => IndividualPolicy::class,
            
            Request::class                => RequestPolicy::class,
            
            // Reporte de Haberes
            ReporteHaberes::class         => ReportePolicyHaber::class,
            ExportarHaberes::class        => ExportarPolicyHaber::class,
            ReporteHaberesAgentes::class  => ReportePolicyHaber::class,
            ExportarHaberesAgentes::class => ExportarPolicyHaber::class,
            General::class                => VistaPreviaReportePolicy::class,
            
            HomeController::class => DashboardPolicy::class,
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
        
        Gate::define('work-bases', function (User $user, array $basesIds) {
            
            try {
                $policy = new RequestGatePolicy();
                
                return $policy->base($user, $basesIds);
            } catch (AuthorizationException $e) {
                abort(403);
            }
        });
        
        Gate::define('work-turnos', function (User $user, array $turnoIds) {
            
            try {
                $policy = new RequestGatePolicy();
                
                return $policy->turno($user, $turnoIds);
            } catch (AuthorizationException $e) {
                abort(403);
            }
        });
        
        Gate::define('work-licencia', function (User $user, Agente $agente, TipoPresentismo $tipo) {
            
            $policy = new TipoPresentismoGatePolicy();
            
            return $policy->licencia($user, $agente, $tipo);
        });
    }
}
