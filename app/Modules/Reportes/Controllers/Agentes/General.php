<?php

namespace Cat\Modules\Reportes\Controllers\Agentes;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Cargo;
use Cat\Models\EstadoContrato;
use Cat\Models\Funcion;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Cat\Modules\Reportes\Controllers\ReporteController;

class General extends ReporteController
{
    /** @var  Collection */
    protected $areas;
    
    /** @var  Turno */
    protected $turno;
    
    /** @var  Base */
    protected $base;
    
    /** @var  \DateTime */
    protected $fechaContrato;
    
    /** @var  TipoContrato */
    protected $tipoContrato;
    
    /** @var  EstadoContrato */
    protected $estadoContrato;
    
    /** @var  Cargo */
    protected $cargo;
    
    /** @var  Funcion */
    protected $funcion;
    
    
    public function index()
    {
        $this->authorize('index', $this);
    
        return view('Reportes::agentes.index-general');
    }
    
    /**
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $this->authorize('search', $this);
    
        $this->setupParams($request)
            ->setupQuery();
        
        /** @var LengthAwarePaginator $return */
        $return = $this->query->paginate(25, ['*'], 'pagina', $this->page);
        
        return View::make('Reportes::agentes.index-general')
            ->with('agentes', $return)
            ->with('base', $this->base)
            ->with('turno', $this->turno)
            ->with('areas', $this->areas)
            ->with('fechaContrato', $this->fechaContrato)
            ->with('cargo', $this->cargo)
            ->with('funcion', $this->funcion)
            ->with('tipoContrato', $this->tipoContrato)
            ->with('estadoContrato', $this->estadoContrato)
            ->with('links', $this->getLinksLikeForm($return, $request))
            ->with('exportar', $this->getExportForm($return, $request, 'reportesAgentesGeneralExport'))
            ;
        
    }
    
    protected function setupParams(Request $request)
    {
        if (!$request->input('fechaContrato') === '') {
            $this->fechaContrato = new \DateTime($request->input('fechaContrato'));
        }
        $this->areas          = new Collection($request->input('areas'));
        $this->page           = (($request->input('page') !== null) ? $request->input('page') : 1);
        $this->base           = Base::find($request->input('base'));
        $this->turno          = Turno::find($request->input('turno'));
        $this->cargo          = Cargo::find($request->input('cargo'));
        $this->funcion        = Funcion::find($request->input('funcion'));
        $this->tipoContrato   = TipoContrato::find($request->input('tipoContrato'));
        $this->estadoContrato = EstadoContrato::find($request->input('estadoContrato'));
        
        return $this;
    }
    
    protected function setupQuery()
    {
        $this->query = Agente::select(['agentes.*'])
            ->with('domicilios')
            ->with('estudio')
            ->with('operativo.base')
            ->with('operativo.turno')
            ->with('operativo.cargo')
            ->with('operativo.funcion')
            ->with('operativo.area')
            ->with('operativo.gerencia')
            ->with('contrato.tipoContrato')
            ->with('contrato.estadoContrato');
        
        $this->query->leftJoin('operativos', function ($join) {
            /** @var JoinClause $join */
            $join->on('operativos.id_agente', '=', 'agentes.id');
            if ($this->base !== null) {
                $join
                    ->where('id_base', '=', $this->base->id);
            }
            
            if ($this->turno !== null) {
                $join
                    ->where('id_turno', '=', $this->turno->id);
            }
            if ($this->cargo !== null) {
                $join
                    ->where('id_cargo', '=', $this->cargo->id);
            }
            if ($this->funcion !== null) {
                $join
                    ->where('id_funcion', '=', $this->funcion->id);
            }
            
            if (!$this->areas->isEmpty()) {
                $join
                    ->whereIn('id_area', $this->areas->all());
            }
            
        });
        
        $this->query->leftJoin('contratos', function ($join) {
            /** @var JoinClause $join */
            $join->on('contratos.id_agente', '=', 'agentes.id');
            
            if ($this->fechaContrato !== null) {
                $join
                    ->whereDate('fecha_ingreso', '<=', $this->fechaContrato);
            }
            
            if ($this->tipoContrato !== null) {
                $join
                    ->where('id_tipo_contrato', '=', $this->tipoContrato->id);
            }
            
            if ($this->estadoContrato !== null) {
                $join
                    ->where('id_estado_contrato', '=', $this->estadoContrato->id);
            }
        });
        
        return $this;
    }
    
}
