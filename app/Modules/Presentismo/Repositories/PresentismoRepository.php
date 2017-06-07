<?php

namespace Cat\Modules\Validation\Repositories;


use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Models\EstadoContrato;
use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Models\TipoContrato;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InfyOm\Generator\Common\BaseRepository;

class PresentismoRepository extends BaseRepository
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
        $activo       = EstadoContrato::where('estado', '=', EstadoContrato::ESTADO_ACTIVO)->first(['id']);
        $tipoLocacion = TipoContrato::where('codigo', '=', Contrato::TIPO_LOCACION)->first(['id']);
        $date         = new \DateTime('tomorrow');
        $eloquent     = Agente::with([
            'presentismos' => function ($presentismos) use ($periodo, $date) {
                $presentismos
                    ->where('id_periodo', '=', $periodo->id)
                    ->whereDate('fecha', '<=', $date->format('Y-m-d'));
            },
        ])->join('operativos', 'agentes.id', '=', 'operativos.id_agente')
            ->join('contratos', 'agentes.id', '=', 'contratos.id_agente')
            ->where('operativos.id_base', $idBase)
            ->where('contratos.id_tipo_contrato', '=', $tipoLocacion->id)
            ->where('contratos.id_estado_contrato', '=', $activo->id);
        
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
}
