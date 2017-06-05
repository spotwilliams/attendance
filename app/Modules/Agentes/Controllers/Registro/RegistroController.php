<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Models\Agente;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Yajra\Datatables\Facades\Datatables;

class RegistroController extends AppBaseController
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
    public function index(Request $request, $base)
    {
        
        return view('Agentes::registro.index')
            ->with('baseActual', $base);
    }
    
    public function table(Request $request, $base)
    {
        $agentes = $this->agenteRepository->getAgentesByBase($base);
        
        /** @var \Yajra\Datatables\Engines\CollectionEngine $datatable */
        $datatable = Datatables::of(new Collection($agentes));
        
        $datatable->filter(function ($instance) use ($request) {
            /** @var \Yajra\Datatables\Engines\CollectionEngine $query */
            $params = $request->all();
            $value  = $params['search']['value'];
            if (!empty($value)) {
                $instance->collection = $instance->collection
                    ->filter(function ($row) use ($value) {
                        return
                            (
                                (Str::contains(strtolower($row->nombre), strtolower($value)) ? true : false)
                                or (Str::contains(strtolower($row->apellido), strtolower($value)) ? true : false)
                                or (Str::contains(strtolower($row->cuit), strtolower($value)) ? true : false)
                            );
                    });
            }
            
        });
        
        $datatable->addColumn('action', function ($agente) {
            $edit   = route('agentesEditPersonales', ['id' => $agente->id]);
            $delete = route('agentesDeletePersonales', ['id' => $agente->id]);
            $show   = route('agentesShow', ['id' => $agente->id]);
            
            return "<a href=\"$edit\" class=\"btn btn-primary\"><i class=\"fa fa-edit\"></i></a>
<!--            <a href=\"$delete\" class=\"btn btn-danger\"><i class=\"fa fa-eraser\"></i></a> -->
            <a href=\"$show\" class=\"btn btn-success\"><i class=\"fa fa-eye\"></i></a>";
        });
        
        return $datatable->make(true);
    }
    
    public function show($id)
    {
        try {
            $agente = Agente::findOrFail($id);
            
            return view('Agentes::registro.show')
                ->with('agente', $agente);
        } catch (\Exception $e) {
            session()->flash('flash_notification.message',
                'Se inten&oacute; acceder a informaci&oacute;n inexistente o no permitida');
            session()->flash('flash_notification.level', 'warning');
            
            return view('Agentes::registro.index', ['base' => 1])->with('baseActual', 1);
            
        }
        
    }
}
