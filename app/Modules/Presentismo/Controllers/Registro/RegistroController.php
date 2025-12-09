<?php

namespace Cat\Modules\Presentismo\Controllers\Registro;

use Cat\Exceptions\FaltanDatosObligatorios;
use Cat\Helpers\HtmlCustoms;
use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Validacion\BaseTurnoSinPeriodo;
use Cat\Modules\Presentismo\Exceptions\Validacion\EnComision;
use Cat\Modules\Presentismo\Exceptions\Validacion\FechaFutura;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoCerrado;
use Cat\Modules\Presentismo\Exceptions\Validacion\Validation;
use Cat\Modules\Presentismo\Services\Helpers\Facilitador;
use Cat\Modules\Presentismo\Services\Registro\Destroy;
use Cat\Modules\Presentismo\Services\Validacion\ValidationNonType;
use Cat\Modules\Presentismo\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Models\Presentismo;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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
        try {
            return $this->{$this->routeMePlease($request)}($request);
            
        } catch (FaltanDatosObligatorios $faltanDatos) {
            $agente = Agente::find($request->input('agente'));
            
            return Response::json([
                'message'     => $faltanDatos->getMessage(),
                'agente'      => $agente->id,
                'presentismo' => new Presentismo(['id_tipo_presentismo' => -1]),
                'button'      => HtmlCustoms::getButtonWithPopOver(null),
            ], 403);
        } catch (\Exception $exception) {
            $agente = Agente::find($request->input('agente'));
            
            return Response::json([
                'message'     => 'Hubo un error inesperado.',
                'tech'        => $exception->getMessage(),
                'track'       => $exception->getTraceAsString(),
                'agente'      => $agente->id,
                'presentismo' => new Presentismo(['id_tipo_presentismo' => -1]),
                'button'      => HtmlCustoms::getButtonWithPopOver(null),
            ], 403);
        }
        
        
    }
    
    /**
     * Indica que operacion ejecutar: CRUD
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
            if ($request->input('presentismo') == -1) {
                $operation = 'destroy';
            } else {
                Presentismo::where('id_agente', '=', $agente->id)
                    ->whereDate('fecha', '=', $fecha->format('Y-m-d'))
                    ->firstOrFail();
                
                $operation = 'update';
            }
            
            
        } catch (ModelNotFoundException $noHayPresentismoCargado) {
            $operation = 'store';
        }
        
        return $operation;
    }
    
    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
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
    
    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
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
        } catch (FechaFutura $e) {
            
            $message = $e->getMessage();
            $code    = 500;
        } catch (BaseTurnoSinPeriodo $e) {
            $message = $e->getMessage();
            $code    = 500;
        } catch (EnComision $e) {
            $message = $e->getMessage();
            $code    = 500;
        } catch (Validation $e) {
            $message = $e->getMessage();
            $code    = 500;
        }
        try {
            
            $presentismo = Presentismo::where('id_agente', '=', $agente->id)
                ->whereDate('fecha', '=', $fecha->format('Y-m-d'))
                ->firstOrFail();
            
        } catch (ModelNotFoundException $noHayPresentismoCargado) {
            $presentismo = new Presentismo(['id' => -1, 'id_tipo_presentismo' => -1]);
            
        }
        
        $button = HtmlCustoms::getButtonsTools($presentismo);
        
        return Response::json([
            'message'     => $message,
            'agente'      => $agente->id,
            'presentismo' => $presentismo,
            'button'      => $button,
        ], $code);
    }
    
    public function destroy(Request $request)
    {
        try {
            
            
            /** @var array $input */
            $input = $request->all();
            /** @var Agente $agente */
            $agente = Agente::find($input['agente']);
            /** @var \DateTime $fecha */
            $fecha = new \DateTime($input['fecha']);
            /** @var Presentismo $presentismo */
            $presentismo = new Presentismo(['id' => -1, 'id_tipo_presentismo' => -1]);
            
            $this->authorize('destroy', $this);
            
            try {
                
                $validador = new ValidationNonType(
                    $agente,
                    new TipoPresentismo(['id' => -1]),
                    $fecha
                );
                // Valido lo necesario
                $validador->execute();
                
                // Servicio de eliminarion
                $destroyer = new Destroy($agente, $fecha);
                $destroyer->execute();
                
                // Preparo el resultado para retornar
                $message = 'El presentismo ha sido borrado.';
                $code    = 200;
                
                
            } catch (PeriodoCerrado $e) {
                
                $message = $e->getMessage();
                $code    = 500;
                $button  = HtmlCustoms::getButtonWithPopOver(null, false, true);
            } catch (FechaFutura $e) {
                
                $message = $e->getMessage();
                $code    = 500;
            }
            
        } catch (AuthorizationException $e) {
            
            $message     = 'Sin permisos para borrar';
            $code        = 403;
            $presentismo = Presentismo::where('id_agente', '=', $agente->id)
                ->whereDate('fecha', '=', $fecha->format('Y-m-d'))
                ->first();
            
            
        }
        $button = HtmlCustoms::getButtonsTools(null);
        
        return Response::json([
            'message'     => $message,
            'agente'      => $agente->id,
            'presentismo' => $presentismo,
            'button'      => $button,
        ], $code);
    }
}
