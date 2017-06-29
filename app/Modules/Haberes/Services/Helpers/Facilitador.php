<?php

namespace Cat\Modules\Haberes\Services\Helpers;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Haber;
use Cat\Models\Operativo;
use Cat\Models\Periodo;
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
     */
    public static function single(Agente $agente, Periodo $periodo)
    {
        try {
            $service = new Registro($agente, $periodo);
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
            $operativos = $base->agentes()
                ->where('operativos.id_turno', '=', $turno->id)
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
        $haberes    = [];
        $operativos = $base->agentes()
            ->where('operativos.id_turno', '=', $turno->id)
            ->with('agente')
            ->get();
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