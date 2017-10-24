<?php

namespace Cat\Modules\Reportes\Controllers\Presentismos;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Turno;
use Cat\Modules\Reportes\Controllers\ReporteController;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class General extends ReporteController
{
    /** @var  Collection */
    protected $areas;
    
    /** @var  Collection */
    protected $turnos;
    
    /** @var  Collection */
    protected $bases;
    
    /** @var  \DateTime */
    protected $desde;
    
    /** @var  \DateTime */
    protected $hasta;
    
    /** @var  Collection */
    protected $funciones;
    
    /** @var  Collection */
    protected $estadoContratos;
    
    /** @var  Collection */
    protected $tipoContratos;
    
    /** @var  bool */
    protected $incluirComentarios;
    
    /** @var Collection */
    protected $tiposPresentismos;
    
    public function index()
    {
        $this->authorize('index', $this);
        
        return view('Reportes::presentismos.index-general');
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
        
        return View::make('Reportes::presentismos.index-general')
            ->with('agentes', $return)
            ->with('bases', $this->bases)
            ->with('turnos', $this->turnos)
            ->with('areas', $this->areas)
            ->with('funcion', $this->funciones)
            ->with('estadoContratos', $this->estadoContratos)
            ->with('tipoContratos', $this->tipoContratos)
            ->with('tiposPresentismos', $this->tiposPresentismos->toArray())
            ->with('desde', $this->desde)
            ->with('hasta', $this->hasta)
            ->with('incluir_comentarios', $this->incluirComentarios)
            ->with('links', $this->getLinksLikeForm($return, $request, 'reportesPresentismoGeneralSearch'))
            ->with('exportar', $this->getExportForm($return, $request, 'reportesPresentismoGeneralExport'));
        
    }
    
    protected function setupParams(Request $request)
    {
        $this->desde              = new \DateTime($request->input('rango_desde'));
        $this->hasta              = new \DateTime($request->input('rango_hasta'));
        $this->areas              = new Collection($request->input('areas'));
        $this->bases              = new Collection($request->input('bases'));
        $this->turnos             = new Collection($request->input('turnos'));
        $this->funciones          = new Collection($request->input('funcion'));
        $this->estadoContratos    = new Collection($request->input('estadoContratos'));
        $this->tiposPresentismos  = new Collection($request->input('tipo_presentismo'));
        $this->tipoContratos      = new Collection($request->input('tipoContratos'));
        $this->incluirComentarios = (($request->input('incluir_comentario') !== null) ? true : false);
        $this->page               = (($request->input('page') !== null) ? $request->input('page') : 1);
        
        return $this;
    }
    
    protected function setupQuery()
    {
        $this->query = Agente::select(['agentes.*'])
            ->with([
                'presentismos' => function ($query) {
                    $query->whereDate('fecha', '>=', $this->desde)
                        ->whereDate('fecha', '<=', $this->hasta)
                        ->orderBy('fecha', 'ASC')
                        ->with('tipoPresentismo');
                    if ($this->incluirComentarios) {
                        $query->with('comentarios.user');
                    }
                    if(!$this->tiposPresentismos->isEmpty()) {
                        $query->whereIn('id_tipo_presentismo', $this->tiposPresentismos->toArray());
                    }
                },
            ])
            ->with('operativo.base')
            ->with('operativo.turno')
            ->with('contrato.tipoContrato');
        
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
            
            if (!$this->funciones->isEmpty()) {
                $join
                    ->whereIn('id_funcion', $this->funciones->all());
            }
            
            if (!$this->areas->isEmpty()) {
                $join
                    ->whereIn('id_area', $this->areas->all());
            }
            
        });
        $this->query->join('contratos', function ($join) {
            /** @var JoinClause $join */
            $join->on('contratos.id_agente', '=', 'agentes.id');
            
            
            if (!$this->tipoContratos->isEmpty()) {
                $join
                    ->whereIn('id_tipo_contrato', $this->tipoContratos->all());
            }
            
            if (!$this->estadoContratos->isEmpty()) {
                $join
                    ->whereIn('id_estado_contrato', $this->estadoContratos->all());
            }
            
        });
        
        
        return $this;
    }
}
