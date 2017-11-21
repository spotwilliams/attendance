<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Models\Agente;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $nombre   = $this->cleanMyInput(Input::get('nombre'));
        $apellido = $this->cleanMyInput(Input::get('apellido'));
        $cuit     = $this->cleanMyInput(Input::get('cuit'));
        
        $agentesEloquent = Agente::select(['*']);
        
        if ($nombre) {
            $agentesEloquent->where(DB::raw('unaccent(nombre)'), 'ILIKE', DB::raw("unaccent('%$nombre%')"));
        }
        
        if ($apellido) {
            
            $agentesEloquent->where(DB::raw('unaccent(apellido)'), 'ILIKE', DB::raw("unaccent('%$apellido%')"));
        }
        if ($cuit) {
            
            $agentesEloquent->where('cuit', 'ILIKE', "%$cuit%");
        }
        $agentesEloquent->with('operativo.base');
        
        $return = $agentesEloquent
            ->paginate(25)
            ->appends(['nombre' => $nombre, 'apellido' => $apellido, 'cuit' => $cuit]);
        
        return View::make('Agentes::registro.search.index')
            ->withAgentes($return);
        
    }
    
    protected function cleanMyInput($input)
    {
        $spec = [',', '-', '.'];
        
        foreach ([] as $s) {
            $input = str_replace($s,'',$input);
        }
        return trim($input);
    }
    
}
