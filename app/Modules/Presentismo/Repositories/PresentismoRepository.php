<?php

namespace Cat\Modules\Presentismo\Repositories;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\EstadoContrato;
use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
//use Cat\Repositories\BaseRepository;

class PresentismoRepository //extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable
        = [
            'id_agente',
            'id_jornada',
            'id_tipo_presentismo',
            'id_padre',
        ];
    
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Presentismo::class;
    }
    
    /**
     * Entrega el Eloquent Model que maneja
     * la lista de agentes con contrato activo del tipo LOCACION. Requiere uso de get
     *
     * @param $idBase
     * @return mixed
     */
    public function agentesAptos($idBase, Periodo $periodo)
    {
        $eloquent = $this->getEloquentAgentes($idBase, $periodo);
        try {
            return $eloquent->get(
                [
                    'agentes.id as id',
                    'agentes.nombre as nombre',
                    'agentes.apellido as apellido',
                    'agentes.cuit as cuit',
                ]
            );
        } catch (QueryException $e) {
            Log::error($e);
            
            return [];
        }
        
    }
    
    /**
     * Genera eloquent de agentes con eager de presentismos
     * @param $idBase
     * @param Periodo $periodo
     * @param \DateTime|null $fechaFin Fecha hasta considerar presentismos. En caso de null, se considera tomorrow
     * @return mixed
     */
    public function getEloquentAgentes($idBase, Periodo $periodo, \DateTime $fechaFin = null)
    {
        $activo       = EstadoContrato::where('estado', '=', EstadoContrato::ESTADO_ACTIVO)->first(['id']);
        $date         = ($fechaFin === null) ? new \DateTime('tomorrow') : $fechaFin;
        $eloquent     = Agente::with([
            'presentismos' => function ($presentismos) use ($periodo, $date): void {
                $presentismos
                    ->where('id_periodo', '=', $periodo->id)
                    ->whereDate('fecha', '<=', $date->format('Y-m-d'));
            },
        ])
            ->join('operativos', 'agentes.id', '=', 'operativos.id_agente')
            ->join('contratos', 'agentes.id', '=', 'contratos.id_agente')
            ->where('operativos.id_base', $idBase)
            ->where('contratos.id_estado_contrato', '=', $activo->id)
            ->orderBy('apellido', 'asc');
        
        return $eloquent;
    }
    
    /**
     * Genera el eloquent de agentes y presentismos entre dos fechas distintas
     * @param Base $base
     * @param \DateTime $desde
     * @param \DateTime $hasta
     * @return mixed
     */
    public function getEloquentAgentesBetweenDates(Base $base, \DateTime $desde, \DateTime $hasta)
    {
        $activo       = EstadoContrato::getEstadosEquivalentesActivos();
        $eloquent     = Agente::with([
            'presentismos' => function ($presentismos) use ($desde, $hasta): void {
                $presentismos
                    ->whereDate('fecha', '>=', $desde->format('Y-m-d'))
                    ->whereDate('fecha', '<=', $hasta->format('Y-m-d'))
                ;
            },
        ])
            ->join('operativos', 'agentes.id', '=', 'operativos.id_agente')
            ->join('contratos', 'agentes.id', '=', 'contratos.id_agente')
            ->where('operativos.id_base', $base->id)
            ->whereIn('contratos.id_estado_contrato', $activo->pluck('id'))
            ->orderBy('apellido', 'asc')
        ->select(['agentes.id as id', 'nombre', 'apellido', 'cuit', 'observacion']);
        
        return $eloquent;
    }
    
    /**
     * Entrega lista de agentes con presentismos paginando
     * @param Base $base
     * @param Periodo $periodo
     * @param \DateTime|null $fechaFin En caso de null se toma la fecha del cierre del periodo
     * @return array
     */
    public function agentesAptosPaginate(Base $base, Periodo $periodo, \DateTime $fechaFin = null)
    {
        if ($fechaFin === null) {
            $fechaFin = new \DateTime($periodo->fecha_fin);
        }
        $eloquent = $this->getEloquentAgentes($base->id, $periodo, $fechaFin);
        
        try {
            return $eloquent->paginate(25);
            
        } catch (QueryException $e) {
            Log::error($e);
            
            return [];
        }
        
    }
}
