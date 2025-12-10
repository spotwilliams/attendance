<?php

namespace Cat\Handlers;

use Illuminate\Database\QueryException;

class Error
{
    
    
    public static function getRespuestaAdecuada(\Exception $e, $entidad)
    {
        $map = [
            QueryException::class => fn($e, $entidad) => self::queryException($e, $entidad),
        ];

        $class = get_class($e);
        if (isset($map[$class])) {
            return call_user_func_array($map[$class], [$e, $entidad]);
        } else {
            throw new \Exception('No se ha implementado handler para clase: ' . $class);
        }
        
    }
    
    
    private static function queryException(QueryException $e, $entidad)
    {
        if (\Illuminate\Support\Str::contains($e->errorInfo[2], 'Duplicate entry')) {
            return "Ya existe un $entidad con los datos provistos";
        } else {
            return $e->getMessage();
        }
    }
    
    
}