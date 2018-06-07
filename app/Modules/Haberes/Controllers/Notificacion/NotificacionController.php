<?php

namespace Cat\Modules\Haberes\Controllers\Notificacion;

use Cat\Models\Base;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Cat\Modules\Haberes\Controllers\Helpers\Data;
use Cat\Modules\Haberes\Services\Helpers\Facilitador;
use Cat\Modules\Haberes\Services\Reporte\Reporte;
use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Repositories\TipoPresentismosRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Laracasts\Flash\Flash;
use Cat\Modules\Haberes\Controllers\GeneralController;

class NotificacionController extends GeneralController
{
    public function __construct()
    {
        parent::__construct();
        
        $this->indexView  = 'Haberes::notificacion.seleccionar-periodos';
        $this->searchView = 'Haberes::notificacion.seleccionar-agentes';
        $this->indexRoute = 'notificacionIndex';
    }
    
    public function send(Request $request)
    {
        $input = $request->all();
        try {
            $periodo = Periodo::findOrFail($input['periodo']);
            $base    = Base::findOrFail($input['base']);
            $turno   = Turno::findOrFail($input['turno']);
            
            /** @var Collection $agentes */
            $agentes = $this->helper->getAgentesForHaberesReport($base, $turno, $periodo);
            
            foreach ($agentes as $haber) {
                $data = [
                    'Nombre'   => $haber->agente->nombre,
                    'Apellido' => $haber->agente->apellido,
                    'CUIT'     => $haber->agente->cuit,
                    'monto'    => $haber->monto_facturado,
                    'faltas'   => (string)TipoPresentismosRepository::getCantFaltasInjustificadas($haber->agente,
                        $haber->periodo),
                ];
                if ($haber->agente->email != '') {
                    
                    Mail::queue('Haberes::notification.mail', ['data' => $data, 'periodo' => $periodo],
                        function ($message) use ($haber) {
                            /** @var Message $message */
                            $message->to($haber->agente->email);
//                        $message->to('presentismo-cat@remain-it.com');
                            $message->subject('Notificacion de haber');
                        });
                }
            }
            Flash::success('Notificaciones enviadas correctamente');
        } catch (\Exception $e) {
            
            Flash::error('No se han podido enviar las notificaciones. Intente nuevamente');
            
        }
        
        return view('Haberes::calculo.index-base');
        
    }
    
    public function reportePreliminar(Request $request)
    {
        $this->authorize('reportePreliminar', $this);
        
        $input = $request->all();
        try {
            $periodo = Periodo::findOrFail($input['periodo']);
            $base    = Base::findOrFail($input['base']);
            $turno   = Turno::findOrFail($input['turno']);
            
            /** @var Collection $agentes */
            $agentes = Facilitador::preliminar($base, $periodo, $turno);
            
            $service = new Reporte(new Collection($agentes));
            
            $service->execute();
            
        } catch (\Exception $e) {
            Flash::error('No se ha podido continuar. Intente nuevamente');
            
            return view('Haberes::calculo.index-base');
        }
        
    }
}
