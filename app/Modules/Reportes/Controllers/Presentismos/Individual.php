<?php

namespace Cat\Modules\Reportes\Controllers\Presentismos;

use Carbon\Carbon;
use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Reportes\Controllers\ReporteController;
use Cat\Modules\Reportes\Services\Formatters\PresentismoAsLine;
use Cat\Modules\Reportes\Services\ReporteAsStream;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
use Cat\Modules\Reportes\Services\Formatters\Presentismo;
use Cat\Modules\Reportes\Services\Reporte;
use Laracasts\Flash\Flash;

class Individual extends ReporteController
{
    
    
    /** @var  \DateTime */
    protected $desde;
    
    /** @var  \DateTime */
    protected $hasta;
    
    /** @var  array| TipoPresentismo */
    protected $tipos;
    
    /** @var  Agente */
    protected $agente;
    
    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function reporte(Request $request)
    {
        $this->authorize('reporte', $this);
        
        $this->setupParams($request)
            ->setupQuery();
        
        /** @var Agente $agente */
        $agente = $this->query->first();
        
        return View::make('Reportes::presentismos.por-agente.reporte.index')
            ->with('agente', $agente)
            ->with('desde', $this->desde)
            ->with('hasta', $this->hasta);
        
    }
    
    public function presentismosFecha(Request $request)
    {
        try {
            $this->setupParams($request)
                ->setupQuery();
            
            /** @var Agente $agente */
            $agente = $this->query->first();
            
            return Response::json($agente->presentismos, 200);
        } catch (\Exception $e) {
            return Response::json([], 500);
        }
        
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function export(Request $request)
    {
        $this->authorize('export', $this);
        
        $this->setupParams($request)
            ->setupQuery();
        
        $service = new ReporteAsStream($this->query, new PresentismoAsLine($this->desde, $this->hasta), true);
        try {
           return  $service->execute();
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            
            return redirect(route('reportesPresentismoIndividualIndex'));
        }
    }
    
    /**
     * @param Request $request
     * @return $this
     */
    protected function setupParams(Request $request)
    {
        $today = Carbon::today();
        
        if ($request->input('start')) {
            $this->desde = new \DateTime($request->input('start'));
        } elseif ($request->input('desde')) {
            $this->desde = new \DateTime($request->input('desde'));
        } else {
            $this->desde = new \DateTime($today->firstOfMonth());
        }
        
        if ($request->input('end')) {
            $this->hasta = new \DateTime($request->input('end'));
        } elseif ($request->input('hasta')) {
            $this->hasta = new \DateTime($request->input('hasta'));
        } else {
            
            $this->hasta = new \DateTime($today->lastOfMonth());
        }
        $this->agente = Agente::findOrFail($request->input('agente'));
        $this->tipos  = $request->input('tipos');
        $this->page   = (($request->input('page') !== null) ? $request->input('page') : 1);
        
        return $this;
    }
    
    /**
     * @return $this
     */
    protected function setupQuery()
    {
        $this->query = Agente::select(['agentes.*'])
            ->with([
                'presentismos' => function ($query) {
                    
                    $query->whereDate('fecha', '>=', $this->desde)
                        ->whereDate('fecha', '<=', $this->hasta);
                    if (!empty($this->tipos)) {
                        $query->whereIn('id_tipo_presentismo', $this->tipos);
                    }
                    
                    $query->orderBy('fecha', 'ASC')
                        ->with('tipoPresentismo')
                        ->with('comentarios.user');
                },
            ])
            ->where('agentes.id', '=', $this->agente->id)
            ->with([
                'operativo.base' => function ($query) {
                    $query->select(['id', 'nombre as nombre_base', 'nombre']);
                },
            ])
            ->with([
                'operativo.turno' => function ($query) {
                    $query->select(['id', 'codigo as turno', 'codigo']);
                },
            ])
            ->with('contrato.tipoContrato');
        
        return $this;
    }
}
