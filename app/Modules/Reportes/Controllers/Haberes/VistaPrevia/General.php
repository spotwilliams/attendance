<?php

namespace Cat\Modules\Reportes\Controllers\Haberes\VistaPrevia;

use Cat\Models\Base;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Cat\Modules\Presentismo\Repositories\PresentismoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    
    /** @var  Periodo */
    protected $periodo;
    
    protected $presentismoRepository;
    
    /**
     * General constructor.
     * @param PresentismoRepository $repository
     */
    public function __construct(PresentismoRepository $repository)
    {
        $this->presentismoRepository = $repository;
        parent::__construct();
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', $this);
        
        return view('Reportes::haberes-vista-previa.index-general');
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(Request $request)
    {
        
        $this->authorize('search', $this);
        $rules = [
            'base'    => 'required|not_in:-1',
            'turno'   => 'required|not_in:-1',
            'periodo' => 'required|not_in:-1',
        
        ];
        $this->validate($request, $rules);
        try {
            $this->setupParams($request)
                ->setupQuery();
            /** @var LengthAwarePaginator $return */
            $return = $this->query->paginate(25, ['*'], 'pagina', $this->page);
            
            return View::make('Reportes::haberes-vista-previa.index-general')
                ->with('agentes', $return)
                ->with('base', $this->base)
                ->with('turno', $this->turno)
                ->with('periodo', $this->periodo)
                ->with('links', $this->getLinksLikeForm($return, $request, 'reportesHaberesVistaPreviaSearch'))
                ->with('exportar', $this->getExportForm($return, $request, 'reportesHaberesAgentesExport'));
        } catch (ModelNotFoundException $e) {
            Flash::error('Al parecer alguno de los datos seleccionados no permiten encontrar un periodo valido');
            
            return view('Reportes::haberes-vista-previa.index-general');
        } catch (\Exception $e) {
            Flash::error('No se pudo generar el reporte, intente nuevamente');
            
            return view('Reportes::haberes-vista-previa.index-general');
            
        }
        
    }
    
    /**
     * @param Request $request
     * @return $this
     */
    protected function setupParams(Request $request)
    {
        $this->base    = Base::findOrFail($request->input('base'));
        $this->turno   = Turno::findOrFail($request->input('turno'));
        $this->periodo = Periodo::findOrFail($request->input('periodo'));
        $this->page    = (($request->input('page') !== null) ? $request->input('page') : 1);
        
        return $this;
    }
    
    protected function setupQuery()
    {
        
        $agentes = $this
            ->presentismoRepository
            ->getEloquentAgentes($this->base->id, $this->periodo);
        
        $this->query = $agentes
            ->select([
                'agentes.id as id',
                'agentes.nombre as nombre',
                'agentes.apellido as apellido',
                'agentes.cuit as cuit',
            ])
            // Override the condition
            ->with([
                'presentismos' => function ($presentismos): void {
                    $presentismos
                        ->where('id_periodo', '=', $this->periodo->id)
//                            ->where('injustificado', '=', true)
                        ->orderBy('fecha', 'ASC');
                },
            ])
            ->with('contrato.tipoContrato')
            ->where('operativos.id_turno', '=', $this->turno->id);
        
        
        return $this;
    }
    
}
