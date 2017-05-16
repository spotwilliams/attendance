<?php

namespace Cat\Modules\Validation\Rules;

use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Models\EstadoContrato;
use Cat\Models\Presentismo;
use Illuminate\Support\Facades\DB;
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
     * Entrega la lista de agentes con contrato activo del tipo LOCACION
     * @param array $filter
     */
    public function agentesAptos($idBase)
    {
        $query = DB::table('agentes')
            ->join('contratos', function ($join) {
                $join->on('agentes.id', '=', 'contratos.id_agente');
            })
            ->join('estado_contratos', function ($join) {
                // Todos los contratos activos (hijos de activo y activo)
                $activo = EstadoContrato::where('estado', '=', EstadoContrato::ESTADO_ACTIVO)->first();
                
                $join->on('contratos.id_estado_contrato', '=', 'estado_contratos.id')
                    ->where('estado', '=', EstadoContrato::ESTADO_ACTIVO)
                    ->orWhere('id_padre', '=', $activo->id);
                
            })
            ->join('tipo_contratos', function ($join) {
                $join->on('contratos.id_tipo_contrato', '=', 'tipo_contratos.id')
                    ->where('codigo', '=', Contrato::TIPO_LOCACION);
                
            })
            ->where('agentes.id_base', $idBase);
        
        try {
//            echo $query->toSql();die;
            return $query->get();
        } catch (\Exception $sqlError) {
            dd($sqlError);
        }
    }
}
