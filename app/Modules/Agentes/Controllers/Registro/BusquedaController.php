<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Models\Agente;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class BusquedaController extends AppBaseController
{
    /** @var  AgenteRepository */
    private $agenteRepository;
    
    
    public function __construct(AgenteRepository $agenteRepo)
    {
        $this->agenteRepository = $agenteRepo;
        $this->middleware('auth');
        
    }
    
    /**
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $input = Input::get('search');
        
        $agentesEloquent = Agente::where('nombre', 'ILIKE', '%'.$input.'%')
            ->orWhere('apellido', 'ILIKE', '%'.$input.'%')
            ->orWhere('dni', 'ILIKE', '%'.$input.'%')
            ->orWhere('cuit', 'ILIKE', '%'.$input.'%')
            ->with('operativo.base');
        
        
        $return = $agentesEloquent
            ->paginate(25)
            ->appends(['search' => $input]);
        
        return View::make('Agentes::registro.search.index')
            ->withAgentes($return);
        
    }
    
    
}
