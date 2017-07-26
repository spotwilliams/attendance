<?php

namespace Cat\Reportes\Controllers\Agentes;

use Cat\Helpers\Pagination\FormPresenter;
use Cat\Models\Agente;
use Cat\Http\Controllers\AppBaseController;
use Cat\Models\Base;
use Cat\Models\Cargo;
use Cat\Models\EstadoContrato;
use Cat\Models\Funcion;
use Cat\Models\Presentismo;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class General extends AppBaseController
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
    
    /** @var  Builder */
    protected $query;
    
    /** @var  int */
    protected $page;
    
    /**
     * Html handler for page links
     * @var FormPresenter
     */
    protected $presenter;
    
    public function __construct()
    {
        $this->middleware('auth');
        
    }
    
    public function index()
    {
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
            ->with('exportar', $this->getExportForm($return, $request))
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
    
    private function getLinksLikeForm(LengthAwarePaginator $paginator, Request $request)
    {
        /** @var FormPresenter $presenter */
        $presenter = new FormPresenter($paginator, 'reportesAgentesGeneralSearch');
        $presenter->setInputsParams($request->all());
        
        return $paginator->links($this->presenter);
    }

    private function getExportForm(LengthAwarePaginator $paginator, Request $request)
    {
        /** @var FormPresenter $presenter */
        $presenter = new FormPresenter($paginator, 'reportesAgentesGeneralExport');
        $presenter->setInputsParams($request->all());
        
        return $presenter->renderOne('Exportar a excel');
    }
}
