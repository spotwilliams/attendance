<?php

namespace Cat\Modules\Haberes\Services\Helpers;

use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Registro\Registro;

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
    public static function bacth($agentes = [], Periodo $periodo)
    {
        foreach ($agentes as $agente) {
            try {
                // Se recibio un id
                if (!($agente instanceof Agente)) {
                    $agente = Agente::findOrFail($agente);
                }
                $service = new Registro($agente, $periodo);
                $service->execute();
            } catch (\Exception $e) {
                // No se debe cortar con el proceso
//                throw $e;
            }
        }
    }
}