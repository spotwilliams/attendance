<?php

namespace Cat\Reportes\Controllers\Presentismos;

use Cat\Helpers\Pagination\FormPresenter;
use Cat\Models\Agente;
use Cat\Http\Controllers\AppBaseController;
use Cat\Models\Base;
use Cat\Models\Presentismo;
use Cat\Models\Turno;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class General extends AppBaseController
{
    /** @var  Collection */
    private $areas;
    
    /** @var  Turno */
    private $turno;
    
    /** @var  Base */
    private $base;
    
    /** @var  \DateTime */
    private $desde;
    
    /** @var  \DateTime */
    private $hasta;
    
    /** @var  Builder */
    private $query;
    
    /** @var  int */
    private $page;
    /**
     * Html handler for page links
     * @var
     */
    private $presenter;
    
    public function __construct()
    {
        $this->middleware('auth');
        
    }
    
    public function index()
    {
        return view('Reportes::presentismos.index-general');
    }
    
    /**
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        
        $this->setupParams($request)
            ->setupQuery();
        
        /** @var LengthAwarePaginator $return */
        $return = $this->query->paginate(25, ['*'], 'pagina', $this->page);
        
        return View::make('Reportes::presentismos.index-general')
            ->with('agentes', $return)
            ->with('base', $this->base)
            ->with('turno', $this->turno)
            ->with('areas', $this->areas)
            ->with('desde', $this->desde)
            ->with('hasta', $this->hasta)
            ->with('links', $this->getLinksLikeForm($return, $request));
        
    }
    
    private function setupParams(Request $request)
    {
        $this->desde = new \DateTime($request->input('desde'));
        $this->hasta = new \DateTime($request->input('hasta'));
        $this->areas = new Collection($request->input('areas'));
        $this->base  = Base::find($request->input('base'));
        $this->turno = Turno::find($request->input('turno'));
        $this->page  = (($request->input('page') !== null) ? $request->input('page') : 1);
        
        return $this;
    }
    
    private function setupQuery()
    {
        $this->query = Agente::select(['agentes.*'])
            ->with([
                'presentismos' => function ($query) {
                    $query->whereDate('fecha', '>=', $this->desde)
                        ->whereDate('fecha', '<=', $this->hasta)
                        ->orderBy('fecha', 'ASC')
                        ->with('tipoPresentismo');
                },
            ])
            ->with('operativo.base')
            ->with('operativo.turno')
            ->with('contrato.tipoContrato');
        
        $this->query->join('operativos', function ($join) {
            /** @var JoinClause $join */
            $join->on('operativos.id_agente', '=', 'agentes.id');
            if ($this->base !== null) {
                $join
                    ->where('id_base', '=', $this->base->id);
            }
            
            if ($this->turno !== null) {
                $join
                    ->where('id_turno', '=', $this->turno->id);
            }
            
            if (!$this->areas->isEmpty()) {
                $join
                    ->whereIn('id_area', $this->areas->all());
            }
            
        });
        
        return $this;
    }
    
    private function getLinksLikeForm(LengthAwarePaginator $paginator, Request $request)
    {
        $this->presenter = new FormPresenter($paginator, 'reportesPresentismoGeneralSearch');
        $this->presenter->setInputsParams($request->all());
        
        return $paginator->links($this->presenter);
    }
}
