<?php

namespace Cat\Modules\Reportes\Controllers\Haberes\Agentes;

use Cat\Helpers\ErrorLogger;
use Cat\Models\Agente;
use Cat\Models\EstadoContrato;
use Cat\Models\Notificacion;
use Cat\Models\Periodo;
use Cat\Models\TipoContrato;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Cat\Modules\Reportes\Controllers\ReporteController;
use Laracasts\Flash\Flash;

class General extends ReporteController
{
    /** @var  array */
    protected $bases;
    
    /** @var  array */
    protected $turnos;
    
    /** @var  array */
    protected $periodos;
    
    /** @var array */
    protected $funciones;
    
    /** @var array */
    protected $areas;
    
    /** @var int */
    protected $page;
    
    protected $query;
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', $this);
        
        return view('Reportes::haberes-agentes.index-general');
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
            'periodo' => 'required',
        ];
        
        $messages = [
            'required' => 'Seleccione al menos uno',
        ];
        $this->validate($request, $rules, $messages);
        
        try {
            $this->setupParams($request)
                ->setupQuery();
            /** @var LengthAwarePaginator $return */
            $return = $this->query->paginate(25, ['*'], 'pagina', $this->page);
            
            return View::make('Reportes::haberes-agentes.index-general')
                ->with('data', $return)
                ->with('periodo', $this->periodos)
                ->with('periodosColection', Periodo::whereIn('id', $this->periodos)->get())
                ->with('bases', new Collection($this->bases))
                ->with('turnos', new Collection($this->turnos))
                ->with('funcion', new Collection($this->funciones))
                ->with('areas', new Collection($this->areas))
                ->with('page', $this->page)
                ->with('links', $this->getLinksLikeForm($return, $request, 'reportesHaberesAgentesIndex'))
                ->with('exportar', $this->getExportForm($return, $request, 'reportesHaberesAgentesExport'));
        } catch (\Exception $e) {
            $track = new ErrorLogger();
            Flash::error($track->track($e));
            
            return view('Reportes::haberes-agentes.index-general');
            
        }
        
    }
    
    protected function setupParams(Request $request)
    {
        $this->periodos  = $request->input('periodo');
        $this->bases     = $request->input('bases') ?: [];
        $this->turnos    = $request->input('turnos') ?: [];
        $this->funciones = $request->input('funcion') ?: [];
        $this->areas     = $request->input('areas') ?: [];
        $this->page      = $request->input('page') ?: 1;
        
        return $this;
    }
    
    protected function setupQuery()
    {
        $this->query = Agente::select(['*']);
        
        $this->query->whereHas('operativo', function ($query): void {
            
            if ($this->bases) {
                $query->whereIn('id_base', $this->bases);
            }
            if ($this->turnos) {
                $query->whereIn('id_turno', $this->turnos);
            }
            if ($this->areas) {
                $query->whereIn('id_area', $this->areas);
            }
            if ($this->funciones) {
                $query->whereIn('id_funcion', $this->funciones);
            }
        })
            ->whereHas('contrato', function ($has): void {
                $locacion = TipoContrato::getEquivalentesLocacion()->pluck('id');
                $activo   = EstadoContrato::getEstadosEquivalentesActivos()->pluck('id');
                $has->whereIn('id_tipo_contrato', $locacion)
                    ->whereIn('id_estado_contrato', $activo);
            })
            ->with([
                'facturas'       => function ($with): void {
                    $with->whereIn('id_periodo', $this->periodos);
                },
                'notificaciones' => function ($with): void {
                    $with->whereIn('id_periodo', $this->periodos)
                        ->where('tipo', '=', Notificacion::REGULAR);
                },
                'haberes'        => function ($with): void {
                    $with->whereIn('id_periodo', $this->periodos);
                },
                'operativo'      => function ($with): void {
                    $with->with([
                        'base',
                        'turno',
                        'area',
                        'funcion',
                    ]);
                },
                'presentismos' => function($with): void {
                    $with->whereIn('id_periodo', $this->periodos);
                }
            ]);
        
        
        return $this;
    }
    
}
