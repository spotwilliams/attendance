<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Models\Agente;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Agentes\Services\Registro\Destroy\Laborales;
use Cat\Modules\Agentes\Services\Registro\Destroy\Operativos;
use Cat\Modules\Agentes\Services\Registro\Destroy\Personales;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;

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
        
        $agentesEloquent = Agente::where('nombre', 'LIKE', "%$input%")
            ->orWhere('apellido', 'LIKE', "%$input%")
            ->orWhere('dni', 'LIKE', "%$input%")
            ->orWhere('cuit', 'LIKE', "%$input%")
            ->with('operativo.base');
        
        
        $return = $agentesEloquent
            ->paginate(25)
            ->appends(['search' => $input]);
        
        return View::make('Agentes::registro.search.index')
            ->withAgentes($return);
        
    }
    
    
}
