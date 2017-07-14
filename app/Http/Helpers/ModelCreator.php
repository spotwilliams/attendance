<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 7/14/17
 * Time: 11:23
 */

namespace Cat\Helpers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModelCreator
{
    /**
     * Metodo que devuelve un objeto de relacion, o un objeto vacio
     * @param Model $provider
     * @param $whatAsk string el nombre de la relacion
     * @param $whatExpect string la clase que espero
     */
    public static function getModelFromRelation(Model $provider, $whatAsk, $whatExpect)
    {
        try {
            /** @var \Cat\Models\Agente $agente */
            $model = $provider->{$whatAsk}()->firstOrFail();
        } catch (ModelNotFoundException $e) {
            $model = new $whatExpect();
        }
        
        return $model;
    }
}