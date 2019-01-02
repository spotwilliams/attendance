<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use Cat\Helpers\Calculation;
use Cat\Helpers\ModelCreator;
use Cat\Models\TipoPresentismo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PresentismoAsLine extends RowDataFormatter
{
    /** @var  \DateTime */
    
    protected $desde;
    /** @var  \DateTime */
    
    protected $hasta;
    
    private $allDays;
    
    /** @var bool */
    protected $comentarios;
    
    /** @var string */
    protected $encabezado;
    
    /** @var bool */
    protected $estado;
    
    /** @var Collection */
    protected $tipos;
    
    public function __construct(
        \DateTime $desde,
        \DateTime $hasta,
        Collection $tipos,
        $comentarios = true,
        $estado = true
    ) {
        
        $this->desde       = $desde;
        $this->hasta       = $hasta;
        $this->comentarios = $comentarios;
        $this->estado      = $estado;
        if ($tipos->isEmpty()) {
            $this->tipos = TipoPresentismo::all();
        } else {
            $this->tipos = TipoPresentismo::whereIn('id', $tipos->toArray())->get();
        }

        $this->allDays    = Calculation::getAllDaysBetween($this->desde, $this->hasta);
        $this->encabezado = 'Apellido;Nombre;CUIT;DNI;Turno;Base;';
        $this->charEmpty  = '';
        foreach ($this->allDays as $fecha) {
            $this->encabezado .= $fecha . ' Codigo;';
            
            if ($this->estado) {
                $this->encabezado .= $fecha . ' Estado;';
            }
            
            if ($this->comentarios) {
                $this->encabezado .= $fecha . ' Comentarios;';
            }
        }
        
        /** @var TipoPresentismo $tipo */
        foreach ($this->tipos as $tipo) {
            $this->encabezado .= $tipo->codigo . ';';
        }
        
    }
    
    
    public function format(Model $agente)
    {
        $agenteReturn
            = $agente->apellido . ';' .
            $agente->nombre . ';' .
            $agente->cuit . ';' .
            $agente->dni . ';' .
            ModelCreator::getDataFromModel($agente, ['operativo', 'turno', 'turno']) . ';' .
            ModelCreator::getDataFromModel($agente, ['operativo', 'base', 'nombre_base']);
        
        $presentismos = $this->transformPresentismo($agente->presentismos);
        $resumen      = $this->getResumen($agente->presentismos);
        
        return $agenteReturn . $presentismos . $resumen;
    }
    
    /**
     * @param Collection $presentismos
     * @return string
     */
    private function transformPresentismo(Collection $presentismos)
    {
        $pres = '';
        
        $array = $presentismos->pluck('fecha')->toArray();
        
        $dates = array_unique(array_merge($this->allDays, $array ? $array : []));
        
        $presArray = $presentismos->keyBy('fecha')->toArray();
        foreach ($dates as $fecha) {
            
            if (isset($presArray[$fecha])) {
                $p = $presArray[$fecha];
                
                $pres .= ';' . $p['tipo_presentismo']['codigo'];
                
                if ($this->estado) {
                    $pres .= ';' . (($p['injustificado'] == true) ? 'Injustificado' : 'Justificado');
                }
                
                if ($this->comentarios) {
                    $pres .= ';' . $this->prepareComentarios($p['comentarios']);
                }
                
            } else {
                $pres .= ";{$this->charEmpty}"; //codigo
                
                if ($this->estado) {
                    
                    $pres .= ";{$this->charEmpty}"; // estado
                }
                if ($this->comentarios) {
                    $pres .= ";{$this->charEmpty}"; // comentario
                }
            }
        }
        
        return $pres;
        
        
    }
    
    protected function getResumen(Collection $presentismos)
    {
        $resumen = ';';
        $usados  = $presentismos->groupBy('tipoPresentismo.codigo');
        
        foreach ($this->tipos as $tipo) {
            $counter = $usados->get($tipo->codigo);
            $resumen .= ($counter ? $counter->count() : 0) . ';';
        }
        
        return $resumen;
    }
    
    /**
     * @param $comentarios
     * @return string
     */
    private function prepareComentarios($comentarios)
    {
        $comentario = '';
        foreach ($comentarios as $comment) {
            $fecha      = (new \DateTime($comment['created_at']))->format('d/m/Y');
            $comentario .= "{$comment['comentario']} (por: {$comment['user']['email']} - el {$fecha}) || ";
        }
        
        return str_replace([',', ';', "\r", "\n", "\r\n"], '-', $comentario);
        
        
    }
    
    public function getEncabezado()
    {
        return $this->encabezado;
    }
}