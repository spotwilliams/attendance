<?php

namespace Cat\Modules\Reportes\Controllers\Haberes\Estado;

use Cat\Models\Base;
use Cat\Models\EstadoPeriodo;
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
            $return = $this->query->paginate();

            return View::make('Reportes::haberes-estado.index-general')
                ->with('data', $return)
                ->with('base', $this->base)
                ->with('turno', $this->turno)
                ->with('periodosSelecciados', $this->periodos)
                ->with('links', $this->getLinksLikeForm($return, $request, 'reportesHaberesEstadoSearch'))
                ->with('exportar', $this->getExportForm($return, $request, 'reportesHaberesEstadoExport'));
    
            ;
        } catch (\Exception $e) {
            Flash::error('No se pudo generar el reporte, intente nuevamente: ' . $e->getMessage());
            
            return view('Reportes::haberes-estado.index-general');
            
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
        
        $this->query = EstadoPeriodo::select(['*'])
            ->with('periodo')
            ->with('base')
            ->with('turno')
            ->whereIn('id_periodo', $this->periodos)
            ->whereIn('id_base', $this->base)
            ->whereIn('id_turno', $this->turno)
            ->orderBy('id_periodo', 'DESC');
        
        return $this;
    }
    
}
