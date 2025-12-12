<?php

namespace Cat\Modules\Presentismo\Controllers\Registro;

use Cat\Helpers\HtmlCustoms;
use Cat\Http\Controllers\AppBaseController;
use Cat\Models\Agente;
use Cat\Models\Presentismo;
use Cat\Modules\Presentismo\Exceptions\Validacion\BaseTurnoSinPeriodo;
use Cat\Modules\Presentismo\Exceptions\Validacion\NoSePuedeInjustificar;
use Cat\Modules\Presentismo\Exceptions\Validacion\NoSePuedeJustificar;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoCerrado;
use Cat\Modules\Presentismo\Exceptions\Validacion\SinDiasDisponibles;
use Cat\Modules\Presentismo\Exceptions\Validacion\SinTopeONoEstablecido;
use Cat\Modules\Presentismo\Exceptions\Validacion\Validation;
use Cat\Modules\Presentismo\Repositories\PresentismoRepository;
use Cat\Modules\Presentismo\Services\Registro\Injustificar;
use Cat\Modules\Presentismo\Services\Registro\Justificar;
use Cat\Modules\Presentismo\Rules\PeriodoActivo;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class JustificacionController extends AppBaseController
{
    /** @var  PresentismoRepository */
    private $presentismoRepository;
    
    public function __construct(PresentismoRepository $presentismoRepo)
    {
        $this->presentismoRepository = $presentismoRepo;
        $this->middleware('auth');
        
    }
    
    public function justificar(Request $request)
    {
        
        try {
            try {
                $this->authorize('justificar', $this);
                /** @var Presentismo $presentismo */
                $presentismo = Presentismo::with('tipoPresentismo')->findOrFail($request->input('id'));
                
                $agente = Agente::findOrFail($request->input('id_agente'));
                
                if (!Gate::allows('work-licencia', [$agente, $presentismo->tipoPresentismo])) {
                    throw new AuthorizationException('No tiene acceso a la licencia especificada');
                }
                
            } catch (AuthorizationException $e) {
                
                $presentismo = Presentismo::findOrFail($request->input('id'));
                
                return Response::json([
                    'message'     => 'No tiene permisos para ejecutar',
                    'agente'      => $presentismo->agente()->first()->id,
                    'presentismo' => $presentismo,
                    'button'      => HtmlCustoms::getButtonsTools($presentismo),
                ], 403);
            }
            
            $service = new Justificar($presentismo);
            
            $service->execute();
            
            $message = 'Se ha justificado la falta.';
            $code    = 200;
            
        } catch (ModelNotFoundException $foundException) {
            
            $message = 'Hubo un error inesperado. Intente nuevamente.';
            $code    = 500;
        } catch (PeriodoCerrado $e) {
            
            $message  = $e->getMessage();
            $code     = 500;
            $disabled = true;
        } catch (SinDiasDisponibles $e) {
            $message  = $e->getMessage();
            $code     = 500;
            $disabled = true;
        } catch (SinTopeONoEstablecido $e) {
            $message  = 'El tipo de presentismo no se puede justificar';
            $code     = 500;
            $disabled = true;
        } catch (NoSePuedeJustificar $e) {
            $message  = $e->getMessage();
            $code     = 500;
            $disabled = true;
        } catch (BaseTurnoSinPeriodo $e) {
            $message  = $e->getMessage();
            $code     = 500;
            $disabled = true;
        } catch (Validation $e) {
            $message  = $e->getMessage();
            $code     = 500;
            $disabled = true;
            
        }
        
        
        return Response::json([
            'message'     => $message,
            'agente'      => $presentismo->agente()->first()->id,
            'presentismo' => $presentismo,
            'button'      => HtmlCustoms::getButtonsTools($presentismo),
        ], $code);
        
        
    }
    
    public function injustificar(Request $request)
    {
        
        try {
            try {
                $this->authorize('injustificar', $this);
                /** @var Presentismo $presentismo */
                $presentismo = Presentismo::with(['tipoPresentismo', 'agente'])->findOrFail($request->input('id'));
                
                $agente = Agente::findOrFail($request->input('id_agente'));
                if (!Gate::allows('work-licencia', [$agente, $presentismo->tipoPresentismo])) {
                    throw new AuthorizationException('No tiene acceso a la licencia especificada');
                }
            } catch (AuthorizationException $e) {
                
                $presentismo = Presentismo::findOrFail($request->input('id'));
                
                return Response::json([
                    'message'     => 'No tiene permisos para ejecutar',
                    'agente'      => $presentismo->agente()->first()->id,
                    'presentismo' => $presentismo,
                    'button'      => HtmlCustoms::getButtonsTools($presentismo),
                
                ], 403);
            }
            
            $ruleDias = new PeriodoActivo(
                $presentismo->agente,
                $presentismo->tipoPresentismo,
                new \DateTime($presentismo->fecha)
            );
            $ruleDias->check();
            $service  = new Injustificar($presentismo);
            
            $service->execute();
            
            $message = 'Se ha injustificado la falta.';
            $code    = 200;
        } catch (NoSePuedeInjustificar $e) {
            $message  = $e->getMessage();
            $code     = 500;
            $disabled = true;
        } catch (Validation $e) {
            $message  = $e->getMessage();
            $code     = 500;
            $disabled = true;
        }
        
        
        return Response::json([
            'message'     => $message,
            'agente'      => $presentismo->agente()->first()->id,
            'presentismo' => $presentismo,
            'button'      => HtmlCustoms::getButtonsTools($presentismo),
        ], $code);
        
        
    }
    
}
