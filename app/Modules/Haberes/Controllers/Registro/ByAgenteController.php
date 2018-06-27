<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Arcanedev\Support\Collection;
use Cat\Helpers\Pagination\FormPresenter;
use Cat\Models\Periodo;
use Cat\Models\TipoContrato;
use Cat\Modules\Agentes\Controllers\Registro\BusquedaController;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Modules\Haberes\Controllers\Eloquenteable;
use Cat\Modules\Haberes\Services\Calculo\CalculadorBatch;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class ByAgenteController extends BusquedaController
{
    
    use Eloquenteable;
    /** @var string */
    protected $searchView;
    
    /** @var string */
    protected $indexRoute;
    
    public function __construct(AgenteRepository $agenteRepo)
    {
        parent::__construct($agenteRepo);
        
        $this->searchView = 'Haberes::calculo.seleccionar-agentes';
        $this->indexRoute = 'haberesIndex';
    }
    
    /**
     * @param Request $request
     * @return $this|\Illuminate\Support\Facades\Response
     */
    public function search(Request $request)
    {
        try {
            $periodo = Periodo::findOrFail($request->input('periodo'));
        } catch (ModelNotFoundException $e) {
            Flash::error('Debe seleccionar un periodo de la lista');
            
            return redirect(route($this->indexRoute));
        }
        
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
        
        $this->addPresentismoEloq($this->agentesEloquent, $periodo);
        /** @var Collection $agentes */
        $agentes = $this->agentesEloquent
            ->with('operativo.base')
            ->with([
                'notificaciones' => function ($with) use ($periodo) {
                    $with->where('id_periodo', '=', $periodo->id);
                },
            ])
            ->get();
        
        $service = new CalculadorBatch($agentes, $periodo);
        $agentes = $service->execute();
        
        return view($this->searchView)
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
