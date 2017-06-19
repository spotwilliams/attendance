<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/8/17
 * Time: 10:47
 */

namespace Cat\Modules;


use Illuminate\Database\Eloquent\Model;

abstract class Service
{
    public abstract function execute();
    
    /**
     * Devuelve un model a partir de un id, y el nombre del model. En caso de no encontrarlo, devuelve un mock con id = -1
     * @param $class string del model
     * @param $id id a buscar
     * @return Model
     */
    protected function getMockModelWhenNull($class, $id)
    {
        $obj = $class::find($id);
        if ($obj === null) {
            $obj = new $class(['id' => $id]);
        }
        
        return $obj;
    }
}


