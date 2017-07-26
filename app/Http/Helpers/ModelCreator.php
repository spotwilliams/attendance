<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 7/14/17
 * Time: 11:23
 */

namespace Cat\Helpers;


use function foo\func;
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
    
    
    public static function getDataFromModel(Model $provider, $relations = [], callable $formatter = null)
    {
        $model = $provider;
        foreach ($relations as $data) {
            $model = $model->{$data};
            if ($model == null) {
                return 'S/D';
            }
        }
        if ($formatter !== null) {
            return call_user_func_array($formatter, [$model]);
        } else {
            
            return $model;
        }
    }
}