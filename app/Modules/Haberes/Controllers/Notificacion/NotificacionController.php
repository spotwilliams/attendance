<?php

namespace Cat\Modules\Haberes\Controllers\Notificacion;

use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Calculo\Calculador;
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
            $agentes = $this->getEloq($periodo, $input['agentes'])->get();
            
            $this->send($periodo, $agentes, 'Haberes::notificacion.mail-template.mensaje-regular');
        } catch (\Exception $e) {
            
            Flash::error('Error inesperado: ' . $e->getMessage());
            
        }
        
        return view('Haberes::notificacion.end')
            ->with('periodo', $periodo)
            ->with('agentes', $agentes);
        
    }
    
    protected function send(Periodo $periodo, Collection $agentes, $mensaje)
    {
        $support = new Calculador();
        foreach ($agentes as $agente) {
            $detalle = $support->reset($agente, $periodo)->execute();
            
            if ($agente->email != '') {
                Mail::queue('Haberes::notificacion.mail-template.main',
                    ['agente' => $agente, 'detalle' => $detalle, 'periodo' => $periodo, 'mensaje' => $mensaje],
                    function ($message) use ($agente) {
                        /** @var Message $message */
                        $message->to($agente->email);
//                        $message->to('notificacionesinternas@gmail.com');
                        $message->subject('Notificacion de haber');
                    });
                Notification::successInstant('Se ha enviado la notificaci&oacute;n a ' . $agente->email);
            } else {
                Notification::errorInstant('El agente ' . $agente->apellido . ', ' . $agente->nombre . ' (CUIT: ' . $agente->cuit . '),  no tiene registrado un mail.');
            }
        }
    }

//    public function reportePreliminar(Request $request)
//    {
//        $this->authorize('reportePreliminar', $this);
//
//        $input = $request->all();
//        try {
//            $periodo = Periodo::findOrFail($input['periodo']);
//            $base    = Base::findOrFail($input['base']);
//            $turno   = Turno::findOrFail($input['turno']);
//
//            /** @var Collection $agentes */
//            $agentes = Facilitador::preliminar($base, $periodo, $turno);
//
//            $service = new Reporte(new Collection($agentes));
//
//            $service->execute();
//
//        } catch (\Exception $e) {
//            Flash::error('No se ha podido continuar. Intente nuevamente');
//
//            return view('Haberes::calculo.index-base');
//        }
//
//    }
}
