<?php

namespace Cat\Modules\Reportes\Controllers\Presentismos;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\TipoPresentismo;
use Cat\Models\Turno;
use Cat\Modules\Reportes\Controllers\ReporteController;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

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
//        $this->authorize('search', $this);
        
        $this->setupParams($request)
            ->setupQuery();
        
        /** @var LengthAwarePaginator $return */
        $return = $this->query->paginate(25, ['*'], 'pagina', $this->page);
        
        return View::make('Reportes::presentismos.por-agente.reporte-individual')
            ->with('agentes', $return)
            ->with('desde', $this->desde)
            ->with('hasta', $this->hasta)
            ->with('links', $this->getLinksLikeForm($return, $request))
            ->with('exportar', $this->getExportForm($return, $request, 'reportesPresentismoIndividualExport'));
        
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
                        ->with('tipoPresentismo');
                },
            ])
            ->where('agentes.id', '=', $this->agente->id)
            ->with('operativo.base')
            ->with('operativo.turno')
            ->with('contrato.tipoContrato');
        
        return $this;
    }
}
