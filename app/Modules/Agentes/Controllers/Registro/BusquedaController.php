<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Models\Agente;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class BusquedaController extends AppBaseController
{
    /** @var  AgenteRepository */
    private $agenteRepository;
    
    /** @var Builder */
    protected $agentesEloquent;
    
    protected $nombre;
    
    protected $apellido;
    
    protected $cuit;
    
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
        $this->prepareQuery();
        $return = $this->agentesEloquent
            ->paginate(25)
            ->appends(['nombre' => $this->nombre, 'apellido' => $this->apellido, 'cuit' => $this->cuit]);
        
        return View::make('Agentes::registro.search.index')
            ->withAgentes($return);
        
    }
    
    protected function prepareQuery()
    {
        $this->nombre   = $this->cleanMyInput(\Illuminate\Support\Facades\Request::input('nombre'));
        $this->apellido = $this->cleanMyInput(\Illuminate\Support\Facades\Request::input('apellido'));
        $this->cuit     = [];
        
        if (!empty(\Illuminate\Support\Facades\Request::input('cuit'))) {
            
            $cuitsInput = is_array(\Illuminate\Support\Facades\Request::input('cuit')) ? \Illuminate\Support\Facades\Request::input('cuit') : explode(',', \Illuminate\Support\Facades\Request::input('cuit'));
            foreach ($cuitsInput as $cuitIn) {
                $this->cuit[] = $this->cleanMyInput($cuitIn);
            }
        }
        
        $this->agentesEloquent = Agente::select(['agentes.*']);
        
        /*
         * En caso que lleguen mas de un
         */
        
        if ($this->nombre) {
            $this->agentesEloquent
//                ->where(DB::raw('unaccent(nombre)'), 'ILIKE', DB::raw("unaccent('%$nombre%')"))
                ->where('nombre', 'ILIKE', "%$this->nombre%");
        }
        
        if ($this->apellido) {

            $this->agentesEloquent
                ->where('apellido', 'ILIKE', "%$this->apellido%");
            //                ->where(DB::raw('unaccent(apellido)'), 'ILIKE', DB::raw("unaccent('%$apellido%')"))
        }
        if ($this->cuit) {
            
            $this->agentesEloquent
                ->whereIn('cuit', $this->cuit)
                ->orWhereIn('dni', $this->cuit);
        }
        $this->agentesEloquent->with('operativo.base');
    }
    
    protected function cleanMyInput($input)
    {
        $spec = [',', '-', '.'];
        
        $input = str_replace($spec, '', $input);
        
        return trim($input);
    }
    
}
