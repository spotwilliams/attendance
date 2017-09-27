<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Presentismo extends RowDataFormatter
{
    protected $allDataAvaliable
        = [
            'nombre'   => '',
            'apellido' => '',
            'dni'      => '',
            'email'    => '',
            'cuit'     => '',
            'turno'    => '',
            'base'     => '',
        ];
    
    public function format(Model $agente)
    {
        $agenteReturn = [
            'nombre'   => $agente->nombre,
            'apellido' => $agente->apellido,
            'dni'      => $agente->dni,
            'email'    => $agente->dni,
            'cuit'     => $agente->cuit,
            'turno'    => $agente->operativo->turno->turno,
            'base'     => $agente->operativo->base->nombre_base,
        ];
        $presentismos = $this->transformPresentismo($agente->presentismos);
        
        return array_merge($agenteReturn, $presentismos->toArray());
    }
    
    private function transformPresentismo(Collection $presentismos)
    {
        $pres = [];
        foreach ($presentismos as $p) {
            $pres[$p->fecha . ' (dia)']         = $p->fecha;
            $pres[$p->fecha . ' (codigo)']      = $p->tipoPresentismo->codigo;
            $pres[$p->fecha . ' (estado)']      = (($p->injustificado == true) ? 'Injustificado' : 'Justificado');
            $pres[$p->fecha . ' (comentario)']  = $p->comentario;
        }
        
        return new Collection($pres);
    }
}