<?php

namespace Cat\Modules\Presentismo\Controllers\Registro;

use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Services\Helpers\Facilitador;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Repositories\PeriodoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Response;
use Yajra\Datatables\Facades\Datatables;

class RegistroController extends AppBaseController
{
    /** @var  PresentismoRepository */
    private $presentismoRepository;
    
    public function __construct(PresentismoRepository $presentismoRepo)
    {
        $this->presentismoRepository = $presentismoRepo;
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
        
        return view('Presentismo::registro.index')
            ->with('periodo', PeriodoRepository::getOrCreatePeriodoActivo(new \DateTime('now')))
            ->with('baseActual', $base);
    }
    
    public function table(Request $request, $base)
    {
        $agentes = $this->presentismoRepository->agentesAptos($base);
        $periodo = PeriodoRepository::getOrCreatePeriodoActivo(new \DateTime('now'));
        
        $agentesConPresentismo = $this
            ->presentismoRepository
            ->addPresentismosForAgentes(
                $agentes,
                $periodo
            );
        /** @var \Yajra\Datatables\Engines\CollectionEngine $datatable */
        $datatable = Datatables::of(new Collection($agentesConPresentismo));
        
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
                                or (Str::contains(strtolower($row->apellido), strtolower($value) ) ? true : false)
                                or (Str::contains(strtolower($row->cuit), strtolower($value)) ? true : false)
                            );
                    });
            }
            
        });
        
        return $datatable->make(true);
    }
    
    /**
     * Show the form for creating a new Presentismo.
     *
     * @return Response
     */
    public function create()
    {
        return view('Presentismo::registro.create');
    }
    
    /**
     * Store a newly created Presentismo in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input           = $request->all();
        $agente          = Agente::find($input['agente']);
        $tipoPresentismo = TipoPresentismo::find($input['presentismo']);
        $fecha           = new \DateTime($input['fecha']);
        
        Facilitador::validarDespuesGuardar($agente, $tipoPresentismo, $fecha);
        
        return Response::json([
            'message'     => session('message'),
            'agente'      => session('agente'),
            'presentismo' => session('presentismo'),
        ], session('code'));
        
    }
    
    /**
     * Display the specified Presentismo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $presentismo = $this->presentismoRepository->findWithoutFail($id);
        
        if (empty($presentismo)) {
            Flash::error('Presentismo not found');
            
            return redirect(route('Presentismo::registro.index'));
        }
        
        return view('Presentismo::registro.show')->with('presentismo', $presentismo);
    }
    
    /**
     * Show the form for editing the specified Presentismo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $presentismo = $this->presentismoRepository->findWithoutFail($id);
        
        if (empty($presentismo)) {
            Flash::error('Presentismo not found');
            
            return redirect(route('Presentismo::registro.index'));
        }
        
        return view('Presentismo::registro.edit')->with('presentismo', $presentismo);
    }
    
    /**
     * Update the specified Presentismo in storage.
     *
     * @param  int $id
     * @param UpdatePresentismoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePresentismoRequest $request)
    {
        $presentismo = $this->presentismoRepository->findWithoutFail($id);
        
        if (empty($presentismo)) {
            Flash::error('Presentismo not found');
            
            return redirect(route('Presentismo::registro.index'));
        }
        
        $presentismo = $this->presentismoRepository->update($request->all(), $id);
        
        Flash::success('Presentismo updated successfully.');
        
        return redirect(route('Presentismo::registro.index'));
    }
    
    /**
     * Remove the specified Presentismo from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $presentismo = $this->presentismoRepository->findWithoutFail($id);
        
        if (empty($presentismo)) {
            Flash::error('Presentismo not found');
            
            return redirect(route('Presentismo::registro.index'));
        }
        
        $this->presentismoRepository->delete($id);
        
        Flash::success('Presentismo deleted successfully.');
        
        return redirect(route('Presentismo::registro.index'));
    }
}
