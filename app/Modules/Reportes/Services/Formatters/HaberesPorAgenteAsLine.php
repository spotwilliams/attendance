<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use Cat\Helpers\ModelCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use \Cat\Modules\Haberes\Services\Calculo\Calculador;
use Cat\Models\Agente;

class HaberesPorAgenteAsLine extends RowDataFormatter
{
    /** var Collection */
    protected $periodos;
    
    /** var string */
    protected $encabezado;
    
    public function __construct(Collection $periodos)
    {
        $this->periodos   = $periodos;
        $this->encabezado = 'Apellido;Nombre;CUIT;Turno;Base';
        $this->charEmpty  = '';
        
        foreach ($this->periodos as $periodo) {
            $mesFacturacion = \Illuminate\Support\Facades\Date::createFromFormat('Y-m-d', $periodo->fecha_fin);
            $mesFacturacion->addMonth(1);
            
            $periodoName      = trans('month.' . $mesFacturacion->format('m'))
                . ' ' . $mesFacturacion->format('y');
            $this->encabezado .= ";$periodoName Monto;$periodoName Notificado;$periodoName Facturado";
        }
    }
    
    
    public function format(Model $agente)
    {
        $agenteReturn
            = $agente->apellido . ';' .
            $agente->nombre . ';' .
            $agente->cuit . ';' .
            ModelCreator::getDataFromModel($agente, ['operativo', 'turno', 'codigo']) . ';' .
            ModelCreator::getDataFromModel($agente, ['operativo', 'base', 'nombre']);
        
        $haberes = $this->detallePorPeriodo(
            $agente,
            $agente->facturas->keyBy('id_periodo'),
            $agente->notificaciones->keyBy('id_periodo'),
            $agente->haberes->keyBy('id_periodo')
        );
        
        return $agenteReturn . $haberes;
    }
    
    /**
     * @param Collection $facturas
     * @param Collection $notificaciones
     * @param Collection $haberes
     * @return string
     */
    private function detallePorPeriodo(
        Agente $agente,
        Collection $facturas,
        Collection $notificaciones,
        Collection $haberes
    ) {
        $detalle = ';';
        
        $service = new Calculador();
        foreach ($this->periodos as $p) {
            
            if ($haberes->get($p->id)) {
                $monto = $haberes->get($p->id)->monto_facturado;
            } else {
                $monto = $service->reset($agente, $p)->execute()->monto;
            }
            if ($facturas->get($p->id)) {
                $facturado = 'Si';
            } else {
                $facturado = 'No';
                
            }
            if ($notificaciones->get($p->id)) {
                $notificado = 'Si';
                
            } else {
                $notificado = 'No';
                
            }
            
            $detalle .= "$monto;$notificado;$facturado;";
        }
        
        return $detalle;
    }
    
    
    public function getEncabezado()
    {
        return $this->encabezado;
    }
}