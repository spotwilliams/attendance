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
    
    public function index(Request $request)
    {
        return view('Reportes::presentismos.por-agente.index')
            ->with('agentes', Agente::where('id', '=', -1)->paginate(25));
    }
    
    public function search(Request $request)
    {
        /** @var View $result */
        $result = parent::search($request);
        /** @var LengthAwarePaginator $agentes */
        $agentes = $result->getData()['agentes'];
        
        return view('Reportes::presentismos.por-agente.index')
            ->with('agentes', $agentes)
            ->with('links', $this->getLinks($agentes, $request));
    }
    
    private function getLinks(LengthAwarePaginator $agentes, Request $request)
    {
        $presenter = new FormPresenter($agentes, 'presentismoPorAgenteSearch');
        $presenter->setInputsParams($request->all());
        
        return $agentes->links($presenter);
    }
    
    public function prepareIndividualAgente(Request $request)
    {
        $this->authorize('prepareIndividualAgente', $this);
        $input = $request->all();
        
        try {
            /** @var Agente $agente */
            $agente = Agente::findOrFail($input['agente']);
            $base   = $agente->base();
            // Controlamos que solo existan 10 dias como maximo
            $dateRange = Calculation::prepareTenDaysDiff($input['desde'], $input['hasta']);
            // Repo
            $presentismoRepo = new PresentismoRepository(app());
            $agentes         = $presentismoRepo
                ->getEloquentAgentesBetweenDates(
                    $base,
                    $dateRange['desde'],
                    $dateRange['hasta']
                )
                ->where('agentes.id', '=', $agente->id)
                ->with('contrato.tipoContrato');
            
            /** @var LengthAwarePaginator $result */
            $result = $agentes->paginate(25);
            
        } catch (ModelNotFoundException $e) {
            Flash::error('El agente o la base no se enctraron');
            
            return redirect(route('presentismoPorAgenteIndex'));
        }
        
        return view('Reportes::presentismos.por-agente.lista')
            ->with('desde', $dateRange['desde'])
            ->with('hasta', $dateRange['hasta'])
            ->with('baseActual', $base)
            ->with('agentes', $result);
    }
    
}
