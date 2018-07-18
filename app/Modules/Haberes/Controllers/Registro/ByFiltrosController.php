<?php

namespace Cat\Modules\Haberes\Controllers\Registro;


use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Models\TipoContrato;
use Cat\Modules\Haberes\Controllers\Eloquenteable;
use Cat\Modules\Haberes\Services\Calculo\CalculadorBatch;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Laracasts\Flash\Flash;

class ByFiltrosController extends \Cat\Modules\Reportes\Controllers\ReporteController
{
    use Eloquenteable;
    
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
    
    /** @var string */
    protected $searchView;
    
    /** @var string */
    protected $indexRoute;
    
    public function __construct()
    {
        parent::__construct();
        $this->searchView = 'Haberes::calculo.seleccionar-agentes';
        $this->indexRoute = 'haberesIndex';
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(Request $request)
    {
        $this->authorize('search', $this);
    
        try {
            $periodo = Periodo::findOrFail($request->input('periodo'));
        } catch (ModelNotFoundException $e) {
            Flash::error('Debe seleccionar un periodo de la lista');
            
            return redirect(route($this->indexRoute));
        }
        
        $this->setupParams($request)
            ->setupQuery();
    
        $this->addPresentismoEloq($this->query, $periodo);
    
        /** @var Collection $return */
        $return = $this->query
            ->with([
                'notificaciones' => function ($with) use ($periodo) {
                    $with->where('id_periodo', '=', $periodo->id);
                },
            ])
            ->get();
        
        $service = new CalculadorBatch($return, $periodo);
        $return = $service->execute();
    
        return View::make($this->searchView)
            ->with('agentes', $return)
            ->with('periodo', $periodo)
            ->with('bases', $this->bases)
            ->with('turnos', $this->turnos)
            ->with('areas', $this->areas)
            ->with('funcion', $this->funciones)
            ->with('estadoContratos', $this->estadoContratos)
            ->with('tipoContratos', $this->tipoContratos);
        
    }
    
    protected function setupParams(Request $request)
    {
        $this->areas           = new Collection($request->input('areas'));
        $this->bases           = new Collection($request->input('bases'));
        $this->turnos          = new Collection($request->input('turnos'));
        $this->funciones       = new Collection($request->input('funcion'));
        $this->estadoContratos = new Collection($request->input('estadoContratos'));
//        $this->tipoContratos   = new Collection($request->input('tipoContratos'));
        // Solo los agentes con locacion
        $this->tipoContratos = TipoContrato::where('codigo', '=', TipoContrato::TIPO_LOCACION)->get()->pluck('id');
        $this->page          = (($request->input('page') !== null) ? $request->input('page') : 1);
        
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
