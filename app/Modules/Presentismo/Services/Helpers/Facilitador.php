<?php

namespace Cat\Modules\Presentismo\Services\Helpers;

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
            $serviceValidacion = new Validation($agente, $tipoPresentismo);
            $serviceValidacion->execute();
            session()->flash('message', 'Validaciones correctas');
            session()->flash('code', 200);
            
        } catch (ValidacionNoSuperada $e) {
            if ($e->getCode() === Descriptor::SIN_DIAS_DISPONIBLES) {
                
                $tipoPresentismo = TipoPresentismo::injusticado();
            }
            session()->flash('message', Descriptor::mySelf($e->getCode())->getDescription());
            session()->flash('code', 500);
    
        }
        finally {
            $serviceResigtro = new Registro($agente, $tipoPresentismo, $fecha);
            $serviceResigtro->execute();
            session()->flash('agente', $agente->id);
            session()->flash('presentismo', $tipoPresentismo->id);
        }
        
    }
}