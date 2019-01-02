<?php

namespace Cat\Modules\Haberes\Controllers;

use Cat\Models\Agente;
use Cat\Models\Periodo;
use Illuminate\Database\Eloquent\Builder;

trait Eloquenteable
{
    /**
     * @param Periodo $periodo
     * @param $ids
     * @return Builder
     */
    protected function getEloq(Periodo $periodo, $ids)
    {
        return $this->addPresentismoEloq(Agente::whereIn('id', $ids), $periodo);
        
    }
    
    /**
     * @param Builder $agenteEloq
     * @param Periodo $periodo
     * @return Builder
     */
    protected function addPresentismoEloq(Builder $agenteEloq, Periodo $periodo)
    {
        return $agenteEloq
            ->with([
                'presentismos'   => function ($with) use ($periodo) {
                    /** @var Builder $with */
                    $with->where('id_periodo', '=', $periodo->id)
                        ->with('turno')
                        ->with('tipoPresentismo')
                        ->with('tipoContrato');
                },
                'facturas'       => function ($with) use ($periodo) {
                    /** @var Builder $with */
                    $with->where('id_periodo', '=', $periodo->id);
                },
                'notificaciones' => function ($with) use ($periodo) {
                    /** @var Builder $with */
                    $with->where('id_periodo', '=', $periodo->id);
                },
            ]);
    }
}