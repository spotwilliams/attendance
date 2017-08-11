<?php

namespace Cat\Modules\Presentismo\Controllers\Registro;

use Cat\Helpers\HtmlCustoms;
use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Validacion\FechaFutura;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoCerrado;
use Cat\Modules\Presentismo\Services\Helpers\Facilitador;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Models\Presentismo;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RegistroController extends AppBaseController
{
    /** @var  PresentismoRepository */
    private $presentismoRepository;
    
    public function __construct(PresentismoRepository $presentismoRepo)
    {
        $this->presentismoRepository = $presentismoRepo;
        $this->middleware('auth');
        
    }
    
    public function registro(Request $request)
    {
        return $this->{$this->routeMePlease($request)}($request);
        
    }
    
    /**
     * Indica que operacion ejecutar
     *
     * @param Request $request
     * @return string
     */
    private function routeMePlease(Request $request)
    {
        $input  = $request->all();
        $agente = Agente::find($input['agente']);
        $fecha  = new \DateTime($input['fecha']);
        try {
            Presentismo::where('id_agente', '=', $agente->id)
                ->whereDate('fecha', '=', $fecha->format('Y-m-d'))
                ->firstOrFail();
            
            $operation = 'update';
            
        } catch (ModelNotFoundException $noHayPresentismoCargado) {
            $operation = 'store';
        }
        
        return $operation;
    }
    
    public function store(Request $request)
    {
        try {
            $this->authorize('store', $this);
            
            return $this->saveOrUpdate($request);
            
            
        } catch (AuthorizationException $e) {
            $input  = $request->all();
            $agente = Agente::find($input['agente']);
            
            return Response::json([
                'message'     => 'Sin permisos para ejecutar',
                'agente'      => $agente->id,
                'presentismo' => new Presentismo(['id_tipo_presentismo' => -1]),
                'button'      => HtmlCustoms::getButtonWithPopOver(null, false, true),
            ], 403);
        }
        
    }
    
    public function update(Request $request)
    {
        try {
            $this->authorize('update', $this);
            
            return $this->saveOrUpdate($request);
            
            
        } catch (AuthorizationException $e) {
            $input  = $request->all();
            $agente = Agente::find($input['agente']);
            $fecha  = new \DateTime($input['fecha']);
            
            $presentismo = Presentismo::where('id_agente', '=', $agente->id)
                ->whereDate('fecha', '=', $fecha->format('Y-m-d'))
                ->first();
            
            return Response::json([
                'message'     => 'Sin permisos para ejecutar',
                'agente'      => $agente->id,
                'presentismo' => $presentismo,
                'button'      => HtmlCustoms::getButtonWithPopOver(null, false, true),
            ], 403);
        }
    }
    
    public function comentario(Request $request)
    {
        $this->authorize('comentario', $this);
        
        $this->validate($request, ['comentario' => 'required|max:255',]);
        $input   = $request->all();
        $jornada = new \DateTime($input['fecha']);
        
        $presentismo = Presentismo::where('id_agente', '=', $input['id_agente'])
            ->whereDate('fecha', '=', $jornada->format('Y-m-d'))
            ->where('id_tipo_presentismo', '=', $input['id_tipo_presentismo'])
            ->first();
        
        try {
            
            $presentismo->comentario       = $input['comentario'];
            $presentismo->usuario          = Auth::user()->email;
            $presentismo->fecha_comentario = (new \DateTime());
            $presentismo->save();
            session()->flash('message', 'Guardado correctamente');
            session()->flash('code', 200);
        } catch (QueryException $e) {
            session()->flash('message', $e->getMessage());
            session()->flash('code', 500);
        }
        
        return Response::json([
            'message'          => session('message'),
            'presentismo'      => $presentismo,
            'usuario'          => $presentismo->usuario,
            'fecha_comentario' => $presentismo->fecha_comentario->format('Y-m-d'),
        ], session('code'));
        
    }
    
    public function saveOrUpdate(Request $request)
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
            
            $message = $e->getMessage();
            $code    = 500;
            $button  = HtmlCustoms::getButtonWithPopOver(null, false, true);
        }
        catch (FechaFutura $e) {
    
            $message = $e->getMessage();
            $code    = 500;
            $button  = HtmlCustoms::getButtonWithPopOver(null, false, true);
        }
        try {
            
            $presentismo = Presentismo::where('id_agente', '=', $agente->id)
                ->whereDate('fecha', '=', $fecha->format('Y-m-d'))
                ->firstOrFail();
            $button      = HtmlCustoms::getButtonWithPopOver($presentismo, $presentismo->injustificado == true);
            
        } catch (ModelNotFoundException $noHayPresentismoCargado) {
            $button      = HtmlCustoms::getButtonWithPopOver(null, false, true);
            $presentismo = new Presentismo(['id' => -1, 'id_tipo_presentismo' => -1]);
            
        }

//        $disabled = (isset($disabled) ? $disabled : false;
        
        return Response::json([
            'message'     => $message,
            'agente'      => $agente->id,
            'presentismo' => $presentismo,
            'button'      => $button,
        ], $code);
    }
}
