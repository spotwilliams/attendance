<?php

namespace Cat\Modules\Reportes\Controllers\Presentismos;

use Carbon\Carbon;
use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Reportes\Controllers\ReporteController;
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
        
        $service = new Reporte($this->query, new Presentismo($this->desde, $this->hasta), true);
        try {
            $service->execute();
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
        $today        = Carbon::today();
        $this->desde  = new \DateTime($today->firstOfMonth());
        $this->hasta  = new \DateTime($today->lastOfMonth());
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
            ->with('operativo.base')
            ->with('operativo.turno')
            ->with('contrato.tipoContrato');
        
        return $this;
    }
}
