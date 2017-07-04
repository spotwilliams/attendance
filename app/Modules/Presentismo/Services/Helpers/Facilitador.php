<?php

namespace Cat\Modules\Presentismo\Services\Helpers;

use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Validacion\Descriptor;
use Cat\Modules\Presentismo\Exceptions\Validacion\SinDiasDisponibles;
use Cat\Modules\Presentismo\Exceptions\Validacion\SinTopeONoEstablecido;
use Cat\Modules\Presentismo\Services\Registro\Registro;
use Cat\Modules\Presentismo\Services\Validacion\Validation;
use Cat\Modules\Presentismo\Exceptions\Validacion\Validation as ValidacionNoSuperada;

class Facilitador
{
    /**
     * @param Agente $agente
     * @param TipoPresentismo $tipoPresentismo
     * @param \DateTime $fecha
     * @return void
     */
    public static function validarDespuesGuardar(Agente $agente, TipoPresentismo $tipoPresentismo, \DateTime $fecha)
    {
        try {
            // Se realizan las validaciones
            $serviceValidacion = new Validation($agente, $tipoPresentismo, $fecha);
            $serviceValidacion->execute();
            
            static::goOn($agente, $tipoPresentismo, $fecha);
            session()->flash('message', 'Se actualizo correctamente');
            session()->flash('code', 200);
            
        } catch (SinDiasDisponibles $e) {
            $tipoPresentismo->injustificado = true;
            
            static::goOn($agente, $tipoPresentismo, $fecha);
            
            session()->flash('message', $e->getMessage());
            session()->flash('code', 500);
        } catch (SinTopeONoEstablecido $e) {
            static::goOn($agente, $tipoPresentismo, $fecha);
            
            session()->flash('message', 'Se actualizo correctamente');
            session()->flash('code', 200);
            
        }
        
    }
    
    private static function goOn(Agente $agente, TipoPresentismo $tipoPresentismo = null, \DateTime $fecha)
    {
        $serviceResigtro = new Registro($agente, $tipoPresentismo, $fecha);
        $serviceResigtro->execute();
    }
}