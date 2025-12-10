<?php

namespace Cat\Modules\Reportes\Controllers\Presentismos;

use Cat\Helpers\Pagination\FormPresenterWithOptions;
use Cat\Models\Agente;
use Cat\Modules\Reportes\Controllers\ReporteController;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

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
    
    /** @var  bool */
    protected $incluirEstado;
    
    /** @var Collection */
    protected $tiposPresentismos;

    /** @var bool */
    protected $incluirSinPresentismos;
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', $this);
        
        return view('Reportes::presentismos.index-general');
    }
    
    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
            ->with('incluir_sin_presentismo', $this->incluirSinPresentismos)
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
        $this->incluirEstado      = (($request->input('incluir_estado') !== null) ? true : false);
        $this->page               = (($request->input('page') !== null) ? $request->input('page') : 1);

        $this->incluirSinPresentismos = (($request->input('incluir_sin_presentismo') !== null) ? true : false);
        return $this;
    }


    private function incluirSinPresentismos() {
        return Agente::select(['agentes.*']);
    }

    /**
     * Retorna la query qye excluye los agentes que no tienen cargado los presentismos
     * @return QueryBuilder
     */
    private function excluirSinPresentismos() {

        return Agente::select(['agentes.*'])
                ->whereHas('presentismos', function ($query): void {
                    $query->whereDate('fecha', '>=', $this->desde)
                            ->whereDate('fecha', '<=', $this->hasta);
                    if (!$this->tiposPresentismos->isEmpty()) {
                        $query->whereIn('id_tipo_presentismo', $this->tiposPresentismos->toArray());
                    }

                });
    }

    protected function setupQuery()
    {

        if($this->incluirSinPresentismos) {
            $this->query = $this->incluirSinPresentismos();
        } else {
            $this->query = $this->excluirSinPresentismos();
        }

        $this->query->with([
                'presentismos' => function ($query): void {
                    $query->whereDate('fecha', '>=', $this->desde)
                        ->whereDate('fecha', '<=', $this->hasta)
                        ->orderBy('fecha', 'ASC')
                        ->with('tipoPresentismo');
                    if ($this->incluirComentarios) {
                        $query->with('comentarios.user');
                    }
                    if (!$this->tiposPresentismos->isEmpty()) {
                        $query->whereIn('id_tipo_presentismo', $this->tiposPresentismos->toArray());
                    }
                },
            ])
            ->with('operativo.base')
            ->with('operativo.turno')
            ->with('contrato.tipoContrato');
        
        $this->query->join('operativos', function ($join): void {
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
        $this->query->join('contratos', function ($join): void {
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
    
    protected function getExportForm(LengthAwarePaginator $paginator, Request $request, $route)
    {
        /** @var FormPresenterWithOptions $presenter */
        $presenter = new FormPresenterWithOptions($paginator, $route);
        $presenter->setInputsParams($request->all());
        
        
        $options = [
            [
                'name' => 'incluir_comentario',
                'text' => 'Exportar con comentarios',
            ],
            [
                'name' => 'incluir_estado',
                'text' => 'Exportar con estados',
            ],
        ];
        
        
        return $presenter->renderOne('Exportar a excel', $options);
    }
}
