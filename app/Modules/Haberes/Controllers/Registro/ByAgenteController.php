<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Arcanedev\Support\Collection;
use Cat\Helpers\Pagination\FormPresenter;
use Cat\Models\Periodo;
use Cat\Models\TipoContrato;
use Cat\Modules\Agentes\Controllers\Registro\BusquedaController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class ByAgenteController extends BusquedaController
{
    
    
    /**
     * @param Request $request
     * @return $this|\Illuminate\Support\Facades\Response
     */
    public function search(Request $request)
    {
        /** @var View $result */
        parent::prepareQuery();
        
        // Solo los agentes con locacion
        $this->agentesEloquent->join('contratos', function ($join) {
            /** @var JoinClause $join */
            $join->on('contratos.id_agente', '=', 'agentes.id');

            $join
                ->whereIn('id_tipo_contrato',
                    TipoContrato::where('codigo', '=', TipoContrato::TIPO_LOCACION)->get()->pluck('id')->toArray());
        });
        
        
        /** @var Collection $agentes */
        $agentes = $this->agentesEloquent
            ->with('operativo.base')
            ->get();
        
        try {
            $periodo = Periodo::findOrFail($request->input('periodo'));
        } catch (ModelNotFoundException $e) {
            Flash::error('Debe seleccionar un periodo de la lista');
            
            return redirect(route('haberesIndex'));
        }
        
        
        return view('Haberes::calculo.seleccionar-agentes')
            ->with('agentes', $agentes)
            ->with('periodo', $periodo);
    }
    
    private function getLinks(LengthAwarePaginator $agentes)
    {
        $presenter = new FormPresenter($agentes, 'haberesSearchByAgente');
        $presenter->setInputsParams([
            'nombre'   => $this->nombre,
            'apellido' => $this->apellido,
            'cuit'     => Input::get('cuit'),
        ]);
        
        return $agentes->links($presenter);
    }
    
}
