<?php

namespace Cat\Modules\Haberes\Services\Sender;

use Cat\Models\Agente;
use Cat\Models\Notificacion;
use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Calculo\Calculador;
use Cat\Modules\Service;
use Illuminate\Mail\Message;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

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
    
    /**
     * Obtiene el detalle para enviar los datos
     * @param Agente $agente
     * @param Periodo $periodo
     * @return mixed
     */
    protected abstract function getArrayDataForSaveNotificacion(Agente $agente, Periodo $periodo);
    
    /**
     * Obtiene el detalle a mandar
     * @param Agente $agente
     * @return string
     */
    protected abstract function getMessage(Agente $agente);
    
    /**
     * @param Agente $agente
     * @return \stdClass
     */
    protected abstract function getDetalle(Agente $agente);
    
    protected function send()
    {
        foreach ($this->agentes as $agente) {
            
            if ($agente->email != '') {
                
                $this->data['mensaje'] = $this->getMessage($agente);
                
                Mail::queue($this->view,
                    [
                        'agente'  => $agente,
                        'detalle' => $this->getDetalle($agente),
                        'periodo' => $this->periodo,
                        'data'    => $this->data,
                        'subject' => $this->subject,
                    ],
                    function ($message) use ($agente): void {
                        /** @var Message $message */
                        $message->to($agente->email);
                        $message->subject($this->subject);
                    });
                
                Notificacion::create($this->getArrayDataForSaveNotificacion($agente, $this->periodo));
                
            }
        }
    }
    
}
