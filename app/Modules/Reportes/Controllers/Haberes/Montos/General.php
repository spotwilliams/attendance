<?php

namespace Cat\Modules\Reportes\Controllers\Haberes\Montos;

use Cat\Models\Base;
use Cat\Models\Haber;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;
use Cat\Modules\Reportes\Controllers\ReporteController;
use Laracasts\Flash\Flash;

class General extends ReporteController
{
    /** @var  Base */
    protected $base;
    
    /** @var  Turno */
    protected $turno;
    
    /** @var  array */
    protected $periodos;
    
    /** @var  Builder */
    protected $queryPeriodos;
    
    
    public function index()
    {
        $this->authorize('index', $this);
        
        return view('Reportes::haberes.index-general');
    }
    
    
    public function search(Request $request)
    {
        
        $this->authorize('search', $this);
        $rules = [
            'base'    => 'not_in:-1',
            'turno'   => 'not_in:-1',
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
            Flash::error('No se pudo generar el reporte, intente nuevamente');
            
            return view('Reportes::haberes.index-general');
            
        }
        
    }
    
    protected function setupParams(Request $request)
    {
        $this->base     = Base::findOrFail($request->input('base'));
        $this->turno    = Turno::findOrFail($request->input('turno'));
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
            ->where('id_base', '=', $this->base->id)
            ->where('id_turno', '=', $this->turno->id)
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
                    $with->where('id_base', '=', $this->base->id)
                        ->where('id_turno', '=', $this->turno->id);
                },
            ]);
        $this->queryPeriodos = Periodo::select(['periodos.*'])
            ->whereIn('id', $this->periodos)
            ->with([
                'estados' => function ($with) {
                    /** @var Builder $with */
                    $with->where('id_base', '=', $this->base->id)
                        ->where('id_turno', '=', $this->turno->id);
                },
            ]);
        
        return $this;
    }
    
}
