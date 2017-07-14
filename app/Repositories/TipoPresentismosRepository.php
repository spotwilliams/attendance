<?php

namespace Cat\Repositories;

use Cat\Helpers\Cache;
use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Models\TipoContrato;
use Cat\Models\TipoPresentismo;
use Illuminate\Support\Collection;

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
        
        /** @var TipoPresentismo $tipoTardanza codigo de los injustifados */
        $tipoTardanza = TipoPresentismo::tardanzas();
        
        /** @var int $diasADescontar Cantidad de dias con faltas no justificadas */
        $diasADescontar = $agente
            ->presentismos()
            ->where('id_periodo', '=', $periodo->id)
            ->where('injustificado', '=', true)
            ->where('id_tipo_presentismo', '<>', $tipoTardanza->id)
            ->count();
        /** @var Collection $tardanzas */
        $tardanzas = self::getTardanzasGroupedByNRows($agente, $periodo);
        /** @var Collection $tardanzaRegistrada */
        foreach ($tardanzas as $tardanzaRegistrada) {
            if ($tardanzaRegistrada->count() === config('cat.presentismos.equivalencia.injustificado.tardanza')) {
                $diasADescontar++;
            }
        }
        if (self::isWorkingOnWeekend($agente)) {
            $diasADescontar = $diasADescontar * config('cat.presentismos.equivalencia.injustificado.fin_semana');
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
    
    public static function getTardanzasGroupedByNRows(Agente $agente, Periodo $periodo)
    {
        /** @var TipoPresentismo $tardanza codigo de los injustifados */
        $tardanza = TipoPresentismo::tardanzas();
        /** @var Collection $tardanzas */
        $tardanzas = $agente
            ->presentismos()
            ->where('injustificado', '=', true)
            ->where('id_periodo', '=', $periodo->id)
            ->where('id_tipo_presentismo', '=', $tardanza->id)
            ->get();
        
        return $tardanzas->chunk(config('cat.presentismos.equivalencia.injustificado.tardanza'));
        
    }
}
