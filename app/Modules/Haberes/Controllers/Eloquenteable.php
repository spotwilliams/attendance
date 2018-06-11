<?php

namespace Cat\Modules\Haberes\Controllers;

use Cat\Models\Agente;
use Cat\Models\Periodo;
use PhpParser\Builder;

trait Eloquenteable
{
    /**
     * @param Periodo $periodo
     * @param $ids
     * @return Builder
     */
    protected function getEloq(Periodo $periodo, $ids)
    {
        return Agente::whereIn('id', $ids)
            ->with([
                'presentismos' => function ($with) use ($periodo) {
                    /** @var Builder $with */
                    $with->where('id_periodo', '=', $periodo->id)
                        ->with('turno')
                        ->with('tipoPresentismo')
                        ->with('tipoContrato');
                },
                'facturas'     => function ($with) use ($periodo) {
                    /** @var Builder $with */
                    $with->where('id_periodo', '=', $periodo->id);
                },
            ]);
    }
}