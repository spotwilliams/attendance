<?php

namespace Cat\Modules\Agentes\Services\Registro;


trait CheckEstudiosAndDomicilio
{
    protected function hasSomeUsefullData($array, $index, $excluding = [])
    {
        foreach ($array as $item => $subArray) {
            if (!in_array($item, $excluding)) {
                if ($subArray[$index] !== '' and $subArray[$index] !== 'null') {
                    
                    return true;
                }
            }
        }
        
        return false;
    }
}