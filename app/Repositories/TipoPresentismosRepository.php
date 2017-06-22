<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Models\TipoContrato;
use Cat\Models\TipoPresentismo;

class TipoPresentismosRepository
{
    
    /**
     *
     * @param bool $cache True: se saca de cache
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getAll($cache = true)
    {
        if ($cache) {
            $bases = Cache::get('all_tipos_presentismo', function () {
                return TipoPresentismo::all();
            });
        } else {
            $bases = TipoPresentismo::all();
        }
        
        return $bases;
    }
    
    /**
     *
     * @param bool $cache True: se saca de cache
     * @return \Illuminate\Database\Eloquent\Collection|mixed|static[]
     */
    public static function getByTipoContrato(TipoContrato $tipoContrato, $cache = true)
    {
        $tipoContratoEloquent = TipoPresentismo::where('aplica', '=', $tipoContrato->codigo)
            ->orWhere('aplica', '=', 'TODOS');
        $key                  = $tipoContrato->codigo . '_tipos_presentismo';
        if ($cache) {
            $bases = Cache::get($key, function () use ($tipoContratoEloquent) {
                return $tipoContratoEloquent->get();
            });
        } else {
            $bases = $tipoContratoEloquent->get();
        }
        
        return $bases;
    }
    
    
    public static function getCantFaltasInjustificadas(Agente $agente, Periodo $periodo)
    {
        
        /** @var TipoPresentismo $tardanza codigo de los injustifados */
        $tardanza = TipoPresentismo::tardanzas();
        
        /** @var int $diasADescontar Cantidad de dias con faltas no justificadas */
        $diasADescontar = $agente
            ->presentismos()
            ->where('id_periodo', '=', $periodo->id)
            ->where('injustificado', '=', 1)
            ->where('id_tipo_presentismo', '<>', $tardanza->id)
            ->count();
        $diasADescontar += self::equivalenteEnTardanzas($tardanza, $agente, $periodo);
        
        if (self::isWorkingOnWeekend($agente)) {
            $diasADescontar = $diasADescontar * 2;
        }

        return $diasADescontar;
    }
    
    private static function isWorkingOnWeekend(Agente $agente)
    {
        return $agente
            ->operativo()
            ->first()
            ->turno()
            ->first()
            ->esFinDeSemana();
    }
    
    public static function equivalenteEnTardanzas(TipoPresentismo $tardanza, Agente $agente, Periodo $periodo)
    {
        $tardanzas = $agente
            ->presentismos()
            ->where('id_periodo', '=', $periodo->id)
            ->where('injustificado', '=', 1)
            ->where('id_tipo_presentismo', '=', $tardanza->id)
            ->count();
        
        return round($tardanzas / 3);
        
    }
}
