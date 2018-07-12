<?php

namespace Cat\Modules\Haberes\Controllers\Notificacion;

use Cat\Helpers\ErrorLogger;
use Cat\Models\Notificacion;
use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Calculo\Calculador;
use Cat\Modules\Haberes\Services\Calculo\CalculadorBatch;
use Cat\Modules\Haberes\Services\Sender\Regular;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Krucas\Notification\Facades\Notification;
use Laracasts\Flash\Flash;
use Cat\Modules\Haberes\Controllers\GeneralController;
use Cat\Modules\Haberes\Controllers\Eloquenteable;

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
}
