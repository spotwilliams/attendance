<?php

namespace Cat\Modules\Haberes\Controllers\Registro;


use Cat\Models\Agente;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class ByFiltrosController extends \Cat\Modules\Reportes\Controllers\ReporteController
{
    /** @var  Collection */
    protected $areas;
    
    /** @var  Collection */
    protected $turnos;
    
    /** @var  Collection */
    protected $bases;
    
    /** @var  Collection */
    protected $funciones;
    
    /** @var  Collection */
    protected $estadoContratos;
    
    /** @var  Collection */
    protected $tipoContratos;
    
    
    /**
     * @param Request $request
     * @return \Illuminate\Support\Facades\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(Request $request)
    {

        $this->setupParams($request)
            ->setupQuery();
        
        /** @var LengthAwarePaginator $return */
        $return = $this->query->paginate(25, ['*'], 'pagina', $this->page);
        
        return View::make('Haberes::calculo.index')
            ->with('agentes', $return)
            ->with('bases', $this->bases)
            ->with('turnos', $this->turnos)
            ->with('areas', $this->areas)
            ->with('funcion', $this->funciones)
            ->with('estadoContratos', $this->estadoContratos)
            ->with('tipoContratos', $this->tipoContratos)
            ->with('links', $this->getLinksLikeForm($return, $request, 'haberesSearchByFiltros'));
        
    }
    
    protected function setupParams(Request $request)
    {
        $this->areas              = new Collection($request->input('areas'));
        $this->bases              = new Collection($request->input('bases'));
        $this->turnos             = new Collection($request->input('turnos'));
        $this->funciones          = new Collection($request->input('funcion'));
        $this->estadoContratos    = new Collection($request->input('estadoContratos'));
        $this->tipoContratos      = new Collection($request->input('tipoContratos'));
        $this->page               = (($request->input('page') !== null) ? $request->input('page') : 1);
        
        return $this;
    }
    
    protected function setupQuery()
    {
        $this->query = Agente::select(['agentes.*'])
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
