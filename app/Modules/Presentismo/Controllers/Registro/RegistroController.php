<?php

namespace Cat\Modules\Presentismo\Controllers\Registro;

use Cat\Helpers\HtmlCustoms;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\JornadaLaborable;
use Cat\Models\Periodo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoCerrado;
use Cat\Modules\Presentismo\Services\Helpers\Facilitador;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Models\Presentismo;
use Cat\Repositories\JornadaLaborableRepository;
use Cat\Repositories\PeriodoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
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
    public function index(Request $request)
    {
        return view('Presentismo::registro.index');
    }
    
    public function prepareListaAgentes(Request $request)
    {
        $this->validate($request, ['base' => 'required|not_in:-1']);
        
        $input = $request->all();
        
        return redirect(route('presentismoListaAgentes',
            ['base' => $input['base'], 'desde' => $input['desde'], 'hasta' => $input['hasta']]));
        
    }
    
    public function listaAgentes(Request $request, $base, $desde, $hasta)
    {
        $input = ['desde' => $desde, 'hasta' => $hasta];
        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($input, [
            'hasta' => 'required|date_format:Y-m-d',
            'desde' => 'date_format:Y-m-d',
        ]);
        
        if ($validator->fails()) {
            dd($validator->errors());
            
            return redirect(route('presentismoIndex'));
        }

//        $today    = new \DateTime('now');
//        $periodo  = PeriodoRepository::getOrCreatePeriodoActivo($today);
//        $tomorrow = $today->modify('+1day');
        try {
            
            $base    = Base::findOrFail($base);
            $desde   = new \DateTime($desde);
            $hasta   = new \DateTime($hasta);
            $agentes = $this->presentismoRepository
                ->getEloquentAgentesBetweenDates(
                    $base,
                    $desde,
                    $hasta
                );
//            $agentes->paginate(25);
        } catch (ModelNotFoundException $e) {
            Flash::error('Se ha seleccionado una base inexistente');
            
            return redirect(route('presentismoIndex'));
        }
        
        return view('Presentismo::registro.lista')
            ->with('desde', $desde)
            ->with('hasta', $hasta)
            ->with('baseActual', $base)
            ->with('agentes', $agentes->paginate(25));
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
        $input  = $request->all();
        $agente = Agente::find($input['agente']);
        $fecha  = new \DateTime($input['fecha']);
        
        try {
            $tipoPresentismo = TipoPresentismo::findOrFail($input['presentismo']);
            
            Facilitador::validarDespuesGuardar($agente, $tipoPresentismo, $fecha);
            // Obtengo lo que guarde para mostrarlo en el front.
            
            $message = session('message');
            $code    = session('code');
            
        } catch (ModelNotFoundException $foundException) {
            
            $message = 'Ha elegido un tipo de presentismo no permitido.';
            $code    = 500;
        } catch (PeriodoCerrado $e) {
            
            $message  = $e->getMessage();
            $code     = 500;
            $disabled = true;
        }
        try {
            
            $presentismo = Presentismo::where('id_agente', '=', $agente->id)
                ->whereDate('fecha', '=', $fecha->format('Y-m-d'))
                ->firstOrFail();
        } catch (ModelNotFoundException $noHayPresentismoCargado) {
            $presentismo = new Presentismo(['id_tipo_presentismo' => -1, 'injustificado' => 1]);
        }
        
        return Response::json([
            'message'     => $message,
            'agente'      => $agente->id,
            'presentismo' => $presentismo,
            'button'      => HtmlCustoms::getButtonWithPopOver(($presentismo->injustificado === 1),
                (isset($disabled) ? $disabled : false)),
        ], $code);
        
        
    }
    
    public function comentario(Request $request)
    {
        $this->validate($request, ['comentario' => 'required|max:255',]);
        $input   = $request->all();
        $jornada = new \DateTime($input['fecha']);
        
        $presentismo = Presentismo::where('id_agente', '=', $input['id_agente'])
            ->whereDate('fecha', '=', $jornada->format('Y-m-d'))
            ->where('id_tipo_presentismo', '=', $input['id_tipo_presentismo'])
            ->first();
        
        try {
            
            $presentismo->comentario = $input['comentario'];
            $presentismo->save();
            session()->flash('message', 'Guardado correctamente');
            session()->flash('code', 200);
        } catch (QueryException $e) {
            session()->flash('message', $e->getMessage());
            session()->flash('code', 500);
        }
        
        return Response::json([
            'message' => session('message'),
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
