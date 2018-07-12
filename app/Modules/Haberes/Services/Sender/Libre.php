<?php

namespace Cat\Modules\Haberes\Services\Sender;

use Cat\Models\Agente;
use Cat\Models\Notificacion;
use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Calculo\Calculador;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Krucas\Notification\Facades\Notification;
use Laracasts\Flash\Flash;
use Cat\Modules\Haberes\Controllers\GeneralController;
use Cat\Modules\Haberes\Controllers\Eloquenteable;

class Libre extends Sender
{
    
    /** @var \DateTime */
    protected $fechaFactura;
    
    /** @var \DateTime */
    protected $fechaPago;
    
    /** @var string */
    protected $mensaje;
    
    /**
     * Regular constructor.
     * @param Periodo $periodo
     * @param Collection $agentes
     * @param \DateTime $fechaFactura
     * @param \DateTime $fechaPago
     */
    public function __construct(
        Periodo $periodo,
        Collection $agentes,
        \DateTime $fechaFactura,
        \DateTime $fechaPago,
        $mensaje
    ) {
        parent::__construct(
            $periodo,
            $agentes,
            'Haberes::notificacion.mails.regular',
            Notificacion::REGULAR
        );
        $this->fechaFactura = $fechaFactura;
        $this->fechaPago    = $fechaPago;
        $this->mensaje      = $mensaje;
    }
    
    public function execute()
    {
        
        $this->data = [
            'mensaje'       => $this->mensaje,
            'fecha_factura' => $this->fechaFactura->format('d/m/Y'),
            'fecha_pago'    => $this->fechaPago->format('d/m/Y'),
        ];
        
        return $this->send();
    }
    
    protected function getArrayDataForSaveNotificacion(Agente $agente, Periodo $periodo)
    {
        return [
            'id_agente'     => $agente->id,
            'id_periodo'    => $this->periodo->id,
            'tipo'          => $this->tipo,
            'mensaje'       => $this->mensaje,
            'fecha_factura' => $this->fechaFactura->format('d/m/Y'),
            'fecha_pago'    => $this->fechaPago->format('d/m/Y'),
        ];
    }
    
    
}