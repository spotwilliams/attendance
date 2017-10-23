<?php

namespace Cat\Modules\Reportes\Controllers\Haberes\Estado;

use Cat\Models\Base;
use Cat\Models\Haber;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;
use Cat\Modules\Reportes\Controllers\ReporteController;
use Laracasts\Flash\Flash;

class General extends ReporteController
{
    /** @var  array */
    protected $base;
    
    /** @var  array */
    protected $turno;
    
    /** @var  array */
    protected $periodos;
    
    /** @var  Builder */
    protected $queryPeriodos;
    
    
    public function index()
    {
        $this->authorize('index', $this);
        
        return view('Reportes::haberes-estado.index-general');
    }
    
    
    public function search(Request $request)
    {
        
        $this->authorize('search', $this);
        $rules = [
            'base'    => 'required',
            'turno'   => 'required',
            'periodo' => 'required',
        
        ];
        $this->validate($request, $rules);
        try {
            $this->setupParams($request)
                ->setupQuery();
            /** @var LengthAwarePaginator $return */
            $return = $this->query->paginate(25, ['*'], 'pagina', $this->page);
            
            return View::make('Reportes::haberes.index-general')
                ->with('haberes', $return)
                ->with('base', $this->base)
                ->with('turno', $this->turno)
                ->with('periodosSelecciados', $this->periodos)
                ->with('periodosResumen', $this->queryPeriodos->get())
                ->with('links', $this->getLinksLikeForm($return, $request, 'reportesHaberesGeneralSearch'))
                ->with('exportar', $this->getExportForm($return, $request, 'reportesHaberesGeneralExport'));
        } catch (\Exception $e) {
            Flash::error('No se pudo generar el reporte, intente nuevamente: ' . $e->getMessage());
            
            return view('Reportes::haberes.index-general');
            
        }
        
    }
    
    protected function setupParams(Request $request)
    {
        
        $this->base = [];
        foreach ($request->input('base') as $b) {
            $this->base[] = (int)$b;
        }
        $this->turno = [];
        foreach ($request->input('turno') as $t) {
            $this->turno[] = (int)$t;
        }
        $this->periodos = [];
        foreach ($request->input('periodo') as $p) {
            $this->periodos[] = (int)$p;
        }
        
        $this->page = (($request->input('page') !== null) ? $request->input('page') : 1);
        
        return $this;
    }
    
    protected function setupQuery()
    {
        $this->query = Haber::select(['haberes.*'])
            ->whereIn('id_base', $this->base)
            ->whereIn('id_turno', $this->turno)
            ->whereIn('id_periodo', $this->periodos)
            ->with([
                'agente' => function ($with) {
                    /** @var Builder $with */
                    $with->with('operativo.base');
                    $with->with('operativo.turno');
                },
            ])
            ->with('base')
            ->with('turno')
            ->with([
                'periodo.estados' => function ($with) {
                    /** @var Builder $with */
                    $with->whereIn('id_base', $this->base)
                        ->whereIn('id_turno', $this->turno);
                },
            ]);
        
        
        $this->query = Periodo::select([
            'periodos.*',
            'estado_periodos.id_base',
            'estado_periodos.id_periodo',
            'estado_periodos.id_turno',
            'estado_periodos.abierto',
        ])
            ->join('estado_periodos', function ($join) {
                /** @var JoinClause $join */
                $join->on('periodos.id', '=', 'estado_periodos.id_periodo');
            })
            ->whereIn('periodos.id', $this->periodos)
            ->whereIn('id_base', $this->base)
            ->whereIn('id_turno', $this->turno)
            ->with([
                'haberes' => function ($query) {
                    /** @var Builder */
                    $query
                        ->whereIn('id_base', $this->base)
                        ->whereIn('id_turno', $this->turno)
                        ->with('agente');
                    
                },
            ]);
        
        $this->queryPeriodos = Periodo::select(['periodos.*', 'estado_periodos.*'])
            ->join('estado_periodos', function ($join) {
                /** @var JoinClause $join */
                $join->on('periodos.id', '=', 'estado_periodos.id_periodo');
            })
            ->whereIn('periodos.id', $this->periodos)
            ->whereIn('id_base', $this->base)
            ->whereIn('id_turno', $this->turno);
        
        return $this;
    }
    
}
