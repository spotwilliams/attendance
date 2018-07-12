<?php

namespace Cat\Modules\Haberes\Services\Sender;

use Cat\Models\Notificacion;
use Cat\Models\Periodo;
use Cat\Modules\Reportes\Services\Formatters\Agente;
use Illuminate\Support\Collection;

class Regular extends Sender
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
        \DateTime $fechaPago
    ) {
        parent::__construct(
            $periodo,
            $agentes,
            'Haberes::notificacion.mails.regular',
            Notificacion::REGULAR
        );
        $this->fechaFactura = $fechaFactura;
        $this->fechaPago    = $fechaPago;
        
        $mesFacturacion = \Carbon\Carbon::createFromFormat('Y-m-d', $this->periodo->fecha_fin);
        $mesFacturacion->addMonth(1);
        $this->mensaje = 'HONORARIOS CORRESPONDIENTES A ' . strtoupper(trans('month.' . $mesFacturacion->format('m'))) . ' DEL ' . $mesFacturacion->format('Y');
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
    
    protected function getArrayDataForSaveNotificacion(\Cat\Models\Agente $agente, Periodo $periodo)
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
