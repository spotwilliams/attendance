<?php

namespace Cat\Modules\Reportes\Controllers\Agentes;

use Cat\Models\Agente;
use Cat\Models\Contrato;
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
    
    /** @var  Collection */
    protected $turnos;
    
    /** @var  Collection */
    protected $bases;
    
    /** @var  array */
    protected $fechaContrato;
    
    /** @var  array */
    protected $fechaIngreso;
    
    /** @var  Collection */
    protected $tipoContratos;
    
    /** @var  Collection */
    protected $estadoContratos;
    
    /** @var  Collection */
    protected $cargos;
    
    /** @var  Collection */
    protected $funcion;
    
    /** @var  string */
    protected $sexo;
    
    /** @var  Collection */
    protected $nivelEstudio;
    
    /** @var  Collection */
    protected $estadoEstudio;
    
    /** @var  Collection */
    protected $gerencias;
    
    /** @var  Collection */
    protected $iibbs;
    
    /** @var  Collection */
    protected $contratosEnFechaIngreso;
    
    /** @var  Collection */
    protected $contratosEnFechaContrato;
    
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
            ->with('bases', $this->bases)
            ->with('turnos', $this->turnos)
            ->with('areas', $this->areas)
            ->with('fechaContrato', $this->fechaContrato)
            ->with('fechaIngreso', $this->fechaIngreso)
            ->with('cargos', $this->cargos)
            ->with('funcion', $this->funcion)
            ->with('tipoContratos', $this->tipoContratos)
            ->with('estadoContratos', $this->estadoContratos)
            ->with('iibbs', $this->iibbs)
            ->with('gerencias', $this->gerencias)
            ->with('nivel_estudios', $this->nivelEstudio)
            ->with('estado_estudios', $this->estadoEstudio)
            ->with('links', $this->getLinksLikeForm($return, $request, 'reportesAgentesGeneralSearch'))
            ->with('exportar', $this->getExportForm($return, $request, 'reportesAgentesGeneralExport'));
        
    }
    
    protected function setupParams(Request $request)
    {
        if (($request->input('fecha_contrato_desde') !== '') and ($request->input('fecha_contrato_hasta') !== '')) {
            $this->fechaContrato['desde']   = new \DateTime($request->input('fecha_contrato_desde'));
            $this->fechaContrato['hasta']   = new \DateTime($request->input('fecha_contrato_hasta'));
            $this->contratosEnFechaContrato = Contrato::select('id')
                ->whereDate('fecha_ingreso', '>=', $this->fechaContrato['desde']->format('Y-m-d'))
                ->whereDate('fecha_ingreso', '<=', $this->fechaContrato['hasta']->format('Y-m-d'))
                ->get();
            
        }
        if (($request->input('fecha_ingreso_desde') !== '') and ($request->input('fecha_ingreso_hasta') !== '')) {
            $this->fechaIngreso['desde'] = new \DateTime($request->input('fecha_ingreso_desde'));
            $this->fechaIngreso['hasta'] = new \DateTime($request->input('fecha_ingreso_hasta'));
            
            $this->contratosEnFechaIngreso = Contrato::select('id')
                ->whereDate('fecha_ingreso_gobierno', '>=', $this->fechaIngreso['desde']->format('Y-m-d'))
                ->whereDate('fecha_ingreso_gobierno', '<=', $this->fechaIngreso['hasta']->format('Y-m-d'))
                ->get();
            
        }
        $this->nivelEstudio  = new Collection($request->input('nivel_estudios'));
        $this->estadoEstudio = new Collection($request->input('estado_estudios'));
        
        $this->sexo      = (($request->input('sexo') == -1) ? null : $request->input('sexo'));
        $this->bases     = new Collection($request->input('bases'));
        $this->areas     = new Collection($request->input('areas'));
        $this->turnos    = new Collection($request->input('turnos'));
        $this->funcion   = new Collection($request->input('funcion'));
        $this->cargos    = new Collection($request->input('cargos'));
        $this->gerencias = new Collection($request->input('gerencias'));
        $this->iibbs     = new Collection($request->input('iibbs'));
        
        $this->tipoContratos   = new Collection($request->input('tipoContratos'));
        $this->estadoContratos = new Collection($request->input('estadoContratos'));
        
        $this->page = (($request->input('page') !== null) ? $request->input('page') : 1);
        
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
        
        if ($this->sexo !== null) {
            $this->query->where('sexo', '=', $this->sexo);
        }
        if (
            (!$this->bases->isEmpty()) or
            (!$this->turnos->isEmpty()) or
            (!$this->cargos->isEmpty()) or
            (!$this->funcion->isEmpty()) or
            (!$this->gerencias->isEmpty()) or
            (!$this->areas->isEmpty())
        ) {
            
            $this->query->join('operativos', function ($join) {
                /** @var JoinClause $join */
                $join->on('operativos.id_agente', '=', 'agentes.id');
                if (!$this->bases->isEmpty()) {
                    $join
                        ->whereIn('id_base', $this->bases->all());
                }
                
                if (!$this->turnos->isEmpty()) {
                    $join
                        ->whereIn('id_turno', $this->turnos->all());
                }
                if (!$this->cargos->isEmpty()) {
                    $join
                        ->whereIn('id_cargo', $this->cargos->all());
                }
                if (!$this->funcion->isEmpty()) {
                    $join
                        ->whereIn('id_funcion', $this->funcion->all());
                }
                
                if (!$this->gerencias->isEmpty()) {
                    $join
                        ->whereIn('id_gerencia', $this->gerencias->all());
                }
                
                if (!$this->areas->isEmpty()) {
                    $join
                        ->whereIn('id_area', $this->areas->all());
                }
            });
        }
        
        if (
            ($this->fechaIngreso !== null) or
            ($this->fechaContrato !== null) or
            (!$this->tipoContratos->isEmpty()) or
            (!$this->estadoContratos->isEmpty()) or
            (!$this->iibbs->isEmpty())
        ) {
            $this->query->join('contratos', function ($join) {
                /** @var JoinClause $join */
                $join->on('contratos.id_agente', '=', 'agentes.id');
                
                if ($this->fechaIngreso !== null) {
                    if ($this->contratosEnFechaIngreso->isEmpty()) {
                        $ids = [-1];
                        
                    } else {
                        
                        $ids = array_keys($this->contratosEnFechaIngreso->keyBy('id')->toArray());
                    }
                    $join
                        ->whereIn('contratos.id', $ids);
                }
                if ($this->fechaContrato !== null) {
                    if ($this->contratosEnFechaContrato->isEmpty()) {
                        $ids = [-1];
                    } else {
                        $ids = array_keys($this->contratosEnFechaContrato->keyBy('id')->toArray());
                    }
                    $join
                        ->whereIn('contratos.id', $ids);
                }
                if (!$this->tipoContratos->isEmpty()) {
                    $join
                        ->whereIn('id_tipo_contrato', $this->tipoContratos->all());
                }
                
                if (!$this->estadoContratos->isEmpty()) {
                    $join
                        ->whereIn('id_estado_contrato', $this->estadoContratos->all());
                }
                if (!$this->iibbs->isEmpty()) {
                    $join
                        ->whereIn('tipo_inscripcion', $this->iibbs->all());
                }
            });
        }
        
        if (
            (!$this->estadoEstudio->isEmpty()) or
            (!$this->nivelEstudio->isEmpty())
        ) {
            $this->query->join('estudios', function ($join) {
                /** @var JoinClause $join */
                $join->on('estudios.id_agente', '=', 'agentes.id');
                
                if (!$this->estadoEstudio->isEmpty()) {
                    $join
                        ->whereIn('estado', $this->estadoEstudio->all());
                }
                if (!$this->nivelEstudio->isEmpty()) {
                    $join
                        ->whereIn('nivel', $this->nivelEstudio->all());
                }
            });
        }
        
        return $this;
    }
    
}
