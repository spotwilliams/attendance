<?php

namespace Cat\Modules\Haberes\Services\Helpers;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Contrato;
use Cat\Models\EstadoContrato;
use Cat\Models\Haber;
use Cat\Models\Operativo;
use Cat\Models\Periodo;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Cat\Modules\Haberes\Services\Calculo\Calculador;
use Cat\Modules\Haberes\Services\Registro\CierrePeriodo;
use Cat\Modules\Haberes\Services\Registro\Registro;
use Illuminate\Database\QueryException;

class Facilitador
{
    /**
     * @param Agente $agente
     * @param Periodo $periodo
     * @param Turno $turno
     * @param Base $base
     * @throws \Exception
     */
    public static function single(Agente $agente, Periodo $periodo, Turno $turno, Base $base)
    {
        try {
            $service = new Registro($agente, $periodo, $turno, $base);
            $service->execute();
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    /**
     * @param array $agentes Los items pueden ser models de Agente o bien ids
     * @param Periodo $periodo
     * @throws \Exception
     */
    public static function batch(Base $base, Periodo $periodo, Turno $turno)
    {
        $periodoCerradoCompleto = true;
        try {
            $tipoLocacion = array_keys(
                TipoContrato::where('codigo', '=', Contrato::TIPO_LOCACION)
                    ->get(['id'])
                    ->keyBy('id')
                    ->toArray()
            );
            $operativos   = $base->agentes()
                ->with('agente')
                ->where('operativos.id_turno', '=', $turno->id)
                ->join('contratos', 'contratos.id_agente', '=', 'agentes.id')
                ->whereIn('contratos.id_tipo_contrato', $tipoLocacion)
                ->get();

            /** @var Operativo $operativo */
            foreach ($operativos as $operativo) {
                try {
                    $service = new Registro($operativo->agente()->first(), $periodo, $turno, $base);
                    $service->execute();
                } catch (QueryException $e) {
                    $periodoCerradoCompleto = false;
                }
            }
            
            if ($periodoCerradoCompleto) {
                $cerradorPeriodo = new CierrePeriodo($periodo, $base, $turno);
                $cerradorPeriodo->execute();
            }
        } catch (QueryException $e) {
            throw $e;
        }
    }
    
    public static function preliminar(Base $base, Periodo $periodo, Turno $turno)
    {
        $activo       = EstadoContrato::where('estado', '=', EstadoContrato::ESTADO_ACTIVO)->first(['id']);
        $tipoLocacion = array_keys(TipoContrato::where('codigo', '=', Contrato::TIPO_LOCACION)
            ->get(['id'])
            ->keyBy('id')
            ->toArray());
        $haberes      = [];
        $operativos   = $base->agentes()
            ->where('operativos.id_turno', '=', $turno->id)
            ->join('contratos', 'agentes.id', '=', 'contratos.id_agente')
            ->where('contratos.id_estado_contrato', '=', $activo->id)
            ->whereIn('contratos.id_tipo_contrato', $tipoLocacion)
            ->with('agente')
            ->get(['operativos.id as id', 'operativos.id_agente as id_agente']);
        
        /** @var Operativo $operativo */
        foreach ($operativos as $operativo) {
            try {
                $suportService          = new Calculador($operativo->agente, $periodo);
                $haber                  = new Haber();
                $haber->monto_facturado = $suportService->execute();
                $haber->periodo         = $periodo;
                $haber->agente          = $operativo->agente;
                $haberes[]              = $haber;
            } catch (QueryException $e) {
            }
        }
        
        return $haberes;
    }
}