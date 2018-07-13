<?php

namespace Cat\Modules\Haberes\Services\Sender;

use Cat\Models\Agente;
use Cat\Models\Notificacion;
use Cat\Models\Periodo;
use Illuminate\Support\Collection;

class Libre extends Sender
{
    
    /** @var \DateTime */
    protected $fechaFactura;
    
    /** @var \DateTime */
    protected $fechaPago;
    
    /** @var string */
    protected $mensaje;
    
    /** @var  */
    protected $monto;
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
        $mensaje,
        $monto
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
        $this->monto = $monto;
    }
    
    public function execute()
    {
        
        $this->data = [
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
    
    protected function getMessage(Agente $agente)
    {
        return $this->mensaje;
    }
    
    protected function getDetalle(Agente $agente)
    {
        return [
            'monto' => $this->monto,
        ];
    }
    
    
}