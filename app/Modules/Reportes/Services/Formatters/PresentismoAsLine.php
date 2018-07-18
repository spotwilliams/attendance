<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use Cat\Helpers\Calculation;
use Cat\Helpers\ModelCreator;
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
    
    public function __construct(\DateTime $desde, \DateTime $hasta, $comentarios = true)
    {
        $this->desde       = $desde;
        $this->hasta       = $hasta;
        $this->comentarios = $comentarios;
        $this->allDays     = Calculation::getAllDaysBetween($this->desde, $this->hasta);
        $this->encabezado  = 'Apellido;Nombre;CUIT;DNI;Turno;Base;';
        $this->charEmpty   = '';
        foreach ($this->allDays as $fecha) {
            $this->encabezado .= $fecha . ' Codigo;';
            $this->encabezado .= $fecha . ' Estado;';
            if ($this->comentarios) {
                $this->encabezado .= $fecha . ' Comentarios;';
            }
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
        
        return $agenteReturn . $presentismos;
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
                $pres .= ';' . (($p['injustificado'] == true) ? 'Injustificado' : 'Justificado');
                if ($this->comentarios) {
                    
                    $pres .= ';' . $this->prepareComentarios($p['comentarios']);
                }
                
            } else {
                $pres .= ";{$this->charEmpty}" //codigo
                    . ";{$this->charEmpty}"; // injustificado
                if ($this->comentarios) {
                    $pres .= ";{$this->charEmpty}"; // comentario
                }
            }
        }
        
        return $pres;
        
        
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