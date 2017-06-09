<?php

namespace Cat\Modules\Haberes\Services\Helpers;

use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Exceptions\Validacion\Descriptor;
use Cat\Modules\Presentismo\Services\Registro\Registro;
use Cat\Modules\Presentismo\Services\Validacion\Validation;
use Cat\Modules\Presentismo\Exceptions\Validacion\Validation as ValidacionNoSuperada;

class Facilitador
{
    /**
     * @param Agente $agente
     * @param TipoPresentismo $tipoPresentismo
     * @param \DateTime $fecha
     * @return mixed
     */
    public static function validarDespuesGuardar(Agente $agente, TipoPresentismo $tipoPresentismo, \DateTime $fecha)
    {
        try {
            // Se realizan las validaciones
            $serviceValidacion = new Validation($agente, $tipoPresentismo, $fecha);
            $serviceValidacion->execute();
            $tipoPresentismo->injustificado = 0;
            
            session()->flash('message', 'Se actualizo correctamente');
            session()->flash('code', 200);
            
        } catch (ValidacionNoSuperada $e) {
            session()->flash('message', Descriptor::mySelf($e->getCode())->getDescription());
            session()->flash('code', 500);
            
            switch ($e->getCode()) {
                case Descriptor::SIN_DIAS_DISPONIBLES : {
                    $tipoPresentismo->injustificado = 1;
                    break;
                }
                case Descriptor::PERIODO_CERRADO : {
                    $tipoPresentismo = null;
                    break;
                }
            }
        }
        static::goOn($agente, $tipoPresentismo, $fecha);
        
        
    }
    
    private static function goOn(Agente $agente, TipoPresentismo $tipoPresentismo = null, \DateTime $fecha)
    {
        if ($tipoPresentismo === null) {
            session()->flash('presentismo', -1);
        } else {
            $serviceResigtro = new Registro($agente, $tipoPresentismo, $fecha);
            $serviceResigtro->execute();
            session()->flash('presentismo', $tipoPresentismo->id);
        }
        session()->flash('agente', $agente->id);
    }
}