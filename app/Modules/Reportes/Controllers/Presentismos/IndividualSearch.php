<?php

namespace Cat\Modules\Reportes\Controllers\Presentismos;

use Cat\Helpers\Calculation;
use Cat\Helpers\Pagination\FormPresenter;
use Cat\Models\Agente;
use Cat\Modules\Agentes\Controllers\Registro\BusquedaController;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class IndividualSearch extends BusquedaController
{
    /**
     * @param Request $request
     * @return $this
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('index', $this);
        
        return view('Reportes::presentismos.por-agente.search.index')
            ->with('agentes', Agente::where('id', '=', -1)->paginate(25));
    }
    
    /**
     * @param Request $request
     * @return $this|\Illuminate\Support\Facades\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(Request $request)
    {
        $this->authorize('search', $this);
        
        /** @var View $result */
        $result = parent::search($request);
        /** @var LengthAwarePaginator $agentes */
        $agentes = $result->getData()['agentes'];
        
        return view('Reportes::presentismos.por-agente.search.index')
            ->with('agentes', $agentes)
            ->with('links', $this->getLinks($agentes, $request));
    }
    
    /**
     * @param LengthAwarePaginator $agentes
     * @param Request $request
     * @return string
     */
    private function getLinks(LengthAwarePaginator $agentes, Request $request)
    {
        $presenter = new FormPresenter($agentes, 'presentismoPorAgenteSearch');
        $presenter->setInputsParams($request->all());
        
        return $agentes->links($presenter);
    }
    
}
