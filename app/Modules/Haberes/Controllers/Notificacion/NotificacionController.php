<?php

namespace Cat\Modules\Haberes\Controllers\Notificacion;

use Cat\Helpers\ErrorLogger;
use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Calculo\CalculadorBatch;
use Cat\Modules\Haberes\Services\Sender\Libre;
use Cat\Modules\Haberes\Services\Sender\Regular;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Krucas\Notification\Facades\Notification;
use Laracasts\Flash\Flash;
use Cat\Modules\Haberes\Controllers\GeneralController;
use Cat\Modules\Haberes\Controllers\Eloquenteable;
use Illuminate\Validation\ValidationException;

class NotificacionController extends GeneralController
{
    use Eloquenteable;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->indexView  = 'Haberes::notificacion.seleccionar-periodos';
        $this->searchView = 'Haberes::notificacion.seleccionar-agentes';
        $this->indexRoute = 'notificacionIndex';
    }
    
    public function sendRegular(Request $request)
    {
        $input = $request->all();
        try {
            /** @var Periodo $periodo */
            $periodo = Periodo::findOrFail($input['periodo']);
            /** @var Collection $agentes */
            $agentes = $this->getEloq($periodo, $input['agentes'])
                ->whereDoesntHave('notificaciones', function ($where) use ($periodo) {
                    $where->where('id_periodo', '=', $periodo->id);
                })
                // Si el agente ya fue notificado, tengo que asegurarme que no se lo haga de nuevo
                ->get();
            
            if ($agentes->isEmpty()) {
                Notification::warningInstant('Todos los agentes seleccionados ya han sido notificados para el periodo seleccionado.');
                
            } else {
                $service = new Regular(
                    $periodo,
                    $agentes,
                    new \DateTime($request->input('fecha_factura')),
                    new \DateTime($request->input('fecha_pago'))
                );
                
                $service->execute();
                Flash::success('Se han notificado los agentes de manera correcta');
            }
            
        } catch (\Exception $e) {
            $log = new ErrorLogger();
            Flash::error($log->track($e));
            
        }
        $calculador = new CalculadorBatch($agentes, $periodo);
        
        return view('Haberes::notificacion.end')
            ->with('periodo', $periodo)
            ->with('agentes', $calculador->execute());
        
    }
    
    public function sendLibre(Request $request)
    {
        
        try {
            $input = $request->all();
            /** @var Periodo $periodo */
            $periodo = Periodo::findOrFail($input['periodo']);
            /** @var Collection $agentes */
            $agentes = $this->getEloq($periodo, $input['agentes'])
                ->get();
            
            // Valido despues para poder tener periodo y agentes ya disponible para mandarlos
            // a la vista con el error
            $this->validate(
                $request,
                ['mensaje' => 'required'],
                ['mensaje.required' => 'El mensaje que el agente debe colocar en la factura es obligatorio']
            );
            
            
            $service = new Libre(
                $periodo,
                $agentes,
                new \DateTime($request->input('fecha_factura')),
                new \DateTime($request->input('fecha_pago')),
                $input['mensaje']
            );
            
            $service->execute();
            Flash::success('Se han notificado los agentes de manera correcta');
            
        } catch (ValidationException $e) {
            
            // Muestro la misma vista desde la que llegue aqui, pero como es por post
            // tengo que pedirle a su controller que la renderize y recupere los datos que
            // tenia la misma
            $controller = new ConfirmarController();
            $view       = $controller->libre($request);
            
            return $view
                ->with('errors', $e->validator->getMessageBag());
            
        } catch (\Exception $e) {
            $log = new ErrorLogger();
            Flash::error($log->track($e));
            
        }
        $calculador = new CalculadorBatch($agentes, $periodo);
        
        return view('Haberes::notificacion.end')
            ->with('periodo', $periodo)
            ->with('agentes', $calculador->execute());
        
    }
    
}
