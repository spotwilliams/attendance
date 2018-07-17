<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use Cat\Helpers\Calculation;
use Cat\Helpers\ModelCreator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Presentismo extends RowDataFormatter
{
    /** @var  \DateTime */
    
    protected $desde;
    /** @var  \DateTime */
    
    protected $hasta;
    
    /** @var  array */
    protected $encabezado;
    
    /** @var bool */
    protected $comentarios;
    
    public function __construct(\DateTime $desde, \DateTime $hasta, $comentarios = true)
    {
        $this->desde       = $desde;
        $this->hasta       = $hasta;
        $this->comentarios = $comentarios;
        $this->encabezado  = array_flip(Calculation::getAllDaysBetween($this->desde, $this->hasta));
        
    }
    
    
    public function format(Model $agente)
    {
        $agenteReturn = [
            'Apellido' => $agente->apellido,
            'Nombre'   => $agente->nombre,
            'CUIT'     => $agente->cuit,
            'DNI'      => $agente->dni,
            'Turno'    => ModelCreator::getDataFromModel($agente, ['operativo', 'turno', 'turno']),
            'Base'     => ModelCreator::getDataFromModel($agente, ['operativo', 'base', 'nombre_base']),
        ];
        
        $presentismos = $this->transformPresentismo($agente->presentismos);
        
        return array_merge($agenteReturn, $presentismos->toArray());
    }
    
    private function transformPresentismo(Collection $presentismos)
    {
        $pres = [];
        
        $temp = array_merge($this->encabezado, $presentismos->keyBy('fecha')->toArray());
        
        foreach ($temp as $fecha => $p) {
            $pres[$fecha . '_codigo']     = 'N/A';
            $pres[$fecha . '_estado']     = 'N/A';
            $pres[$fecha . '_comentario'] = 'N/A';
    
            if (is_array($p)) {

//                $pres[$fecha . '_dia']        = $p['fecha'];
                $pres[$fecha . '_codigo']     = $p['tipo_presentismo']['codigo'];
                $pres[$fecha . '_estado']     = (($p['injustificado'] == true) ? 'Injustificado' : 'Justificado');
                $pres[$fecha . '_comentario'] = $this->prepareComentarios($p['comentarios']);
            }
            if (!$this->comentarios) {
                unset($pres[$fecha . '_comentario']);
            }
        }
        
        return new Collection($pres);
        
        
    }
    
    private function prepareComentarios($comentarios)
    {
        $comentario = '';
        foreach ($comentarios as $comment) {
            $fecha      = (new \DateTime($comment['created_at']))->format('d/m/Y');
            $comentario .= "{$comment['comentario']} (por: {$comment['user']['email']} - el {$fecha})" . PHP_EOL;
        }
        
        return $comentario;
        
        
    }
    
    public function getEncabezado()
    {
        $encabezadoToReturn = [
            'Apellido',
            'Nombre',
            'CUIT',
            'DNI',
            'Turno',
            'Base',
        ];
        foreach ($this->encabezado as $fecha => $empty) {
            $encabezadoToReturn[] = $fecha . '_codigo';
            $encabezadoToReturn[] = $fecha . '_estado';
            $encabezadoToReturn[] = $fecha . '_comentario';
            
        }
        
        return ($encabezadoToReturn);
    }
}