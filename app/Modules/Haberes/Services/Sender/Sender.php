<?php

namespace Cat\Modules\Haberes\Services\Sender;

use Cat\Models\Notificacion;
use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Calculo\Calculador;
use Cat\Modules\Service;
use Illuminate\Mail\Message;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Krucas\Notification\Facades\Notification;

abstract class Sender extends Service
{
    /** @var string */
    protected $view;
    
    /** @var string */
    protected $subject;
    
    /** @var string */
    protected $tipo;
    
    /** @var Periodo */
    protected $periodo;
    
    /** @var Collection */
    protected $agentes;
    
    /** @var array */
    protected $data;
    
    /** @var Calculador */
    protected $support;
    
    /**
     * Sender constructor.
     * @param Periodo $periodo
     * @param Collection $agentes
     * @param $view
     * @param array $data
     * @param string $subject
     */
    public function __construct(
        Periodo $periodo,
        Collection $agentes,
        $view,
        $tipo,
        $data = [],
        $subject = 'Notificacion de factura'
    ) {
        $this->periodo = $periodo;
        $this->agentes = $agentes;
        $this->data    = $data;
        $this->subject = $subject;
        $this->support = new Calculador();
        $this->view    = $view;
        $this->tipo    = $tipo;
    }
    
    protected function send()
    {
        foreach ($this->agentes as $agente) {
            $detalle = $this->support->reset($agente, $this->periodo)->execute();
            
            if ($agente->email != '') {
                
                
                Mail::queue($this->view,
                    [
                        'agente'  => $agente,
                        'detalle' => $detalle,
                        'periodo' => $this->periodo,
                        'data'    => $this->data,
                        'subject' => $this->subject,
                    ],
                    function ($message) use ($agente) {
                        /** @var Message $message */
                        $message->to($agente->email);
                        $message->subject($this->subject);
                    });
                
                Notificacion::create([
                    'id_agente'  => $agente->id,
                    'id_periodo' => $this->periodo->id,
                    'tipo'       => $this->tipo,
                ]);
                
            }
        }
    }
    
}
