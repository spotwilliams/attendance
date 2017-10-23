<?php

namespace Cat\Modules\Reportes\Controllers\Haberes\Agentes;

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
    /** @var  array */
    protected $base;
    
    /** @var  array */
    protected $turno;
    
    /** @var  int */
    protected $periodo;
    
    
    public function index()
    {
        $this->authorize('index', $this);
        
        return view('Reportes::haberes-agentes.index-general');
    }
    
    
    public function search(Request $request)
    {
        
        $this->authorize('search', $this);
        $rules = [
            'base'    => 'required',
            'turno'   => 'required',
            'periodo' => 'not_in:-1',
        
        ];
        $this->validate($request, $rules);
        
        try {
            $this->setupParams($request)
                ->setupQuery();
            /** @var LengthAwarePaginator $return */
            $return = $this->query->paginate(25, ['*'], 'pagina', $this->page);
            
            return View::make('Reportes::haberes-agentes.index-general')
                ->with('data', $return)
                ->with('base', $this->base)
                ->with('turno', $this->turno)
                ->with('periodo', $this->periodo)
                ->with('links', $this->getLinksLikeForm($return, $request, 'reportesHaberesAgentesIndex'))
                ->with('exportar', $this->getExportForm($return, $request, 'reportesHaberesAgentesExport'));
        } catch (\Exception $e) {
            Flash::error('No se pudo generar el reporte, intente nuevamente');
            
            return view('Reportes::haberes-agentes.index-general');
            
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
        $this->periodo = (int)$request->input('periodo');
        $this->page    = (($request->input('page') !== null) ? $request->input('page') : 1);
        
        return $this;
    }
    
    protected function setupQuery()
    {
        $this->query = Haber::select(['haberes.*'])
            ->whereIn('id_base', $this->base)
            ->whereIn('id_turno', $this->turno)
            ->where('id_periodo', '=', $this->periodo)
            ->with('agente')
            ->with('base')
            ->with('turno');
        
        
        return $this;
    }
    
}
