<?php

namespace Cat\Modules\Reportes\Controllers\Presentismos;

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
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return Response
     */
    public function reporte(Request $request)
    {
        $this->authorize('reporte', $this);
        
        $this->setupParams($request)
            ->setupQuery();
        
        /** @var LengthAwarePaginator $return */
        $return = $this->query->paginate(25, ['*'], 'pagina', $this->page);
        
        return View::make('Reportes::presentismos.por-agente.reporte-individual')
            ->with('agentes', $return)
            ->with('desde', $this->desde)
            ->with('hasta', $this->hasta)
            ->with('links', $this->getLinksLikeForm($return, $request, 'reportesPresentismoIndividualSearch'))
            ->with('exportar', $this->getExportForm($return, $request, 'reportesPresentismoIndividualExport'));
        
    }
    
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
    
    protected function setupParams(Request $request)
    {
        $this->desde  = new \DateTime($request->input('desde'));
        $this->hasta  = new \DateTime($request->input('hasta'));
        $this->agente = Agente::findOrFail($request->input('agente'));
        $this->tipos  = $request->input('tipos');
        $this->page   = (($request->input('page') !== null) ? $request->input('page') : 1);
        
        return $this;
    }
    
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
                        ->with('comentarios.user')
                    ;
                },
            ])
            ->where('agentes.id', '=', $this->agente->id)
            ->with('operativo.base')
            ->with('operativo.turno')
            ->with('contrato.tipoContrato');
        
        return $this;
    }
}
