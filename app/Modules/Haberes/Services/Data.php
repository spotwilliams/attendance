<?php

namespace Cat\Modules\Haberes\Controllers\Helpers;

use Cat\Models\Base;
use Cat\Models\Contrato;
use Cat\Models\Haber;
use Cat\Models\Operativo;
use Cat\Models\Periodo;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Cat\Modules\Presentismo\Repositories\PresentismoRepository;
use Doctrine\DBAL\Query\QueryException;

class Data
{
    protected $repository;
    
    public function __construct(PresentismoRepository $repository)
    {
        $this->repository = $repository;
    }
    
    
    public function getAgentes(Periodo $periodo, Base $base, Turno $turno)
    {
        $tipoLocacion = array_keys(TipoContrato::where('codigo', '=', Contrato::TIPO_LOCACION)
            ->get(['id'])
            ->keyBy('id')
            ->toArray());
        
        $agentes = $this
            ->repository
            ->getEloquentAgentes($base->id, $periodo);
        
        $agentes
            // Override the condition
            ->with([
                'presentismos' => function ($presentismos) use ($periodo) {
                    $presentismos
                        ->whereDate('fecha', '>=', $periodo->fecha_comienzo)
                        ->whereDate('fecha', '<=', $periodo->fecha_fin)
                        ->where('injustificado', '=', 1)
                        ->orderBy('fecha', 'ASC');
                },
            ])
            ->with('contrato.tipoContrato')
            ->whereIn('contratos.id_tipo_contrato', $tipoLocacion)
            ->where('operativos.id_turno', '=', $turno->id);
        
        return $agentes;
    }
    
    public function getAgentesForHaberesReport(Base $base, Turno $turno, Periodo $periodo)
    {
        $haberes = Haber::where('id_base', $base->id)
            ->where('id_turno', '=', $turno->id)
            ->where('id_periodo', '=', $periodo->id)
            ->with('agente');
        
        try {
            return $haberes->get();
        } catch (QueryException $e) {
            
            return [];
        }
    }
}
