<?php

namespace Cat\Exceptions;

class MainDescriptor
{
    /** @var  int */
    protected $errorCode;
    
    /** @var  string */
    protected $errorDescription;
    
    /** @var  array Array key/values con codigo de error y descripcion */
    protected static $errorMap;
    
    
    protected function __construct($code, $descripcion)
    {
        $this->errorCode        = $code;
        $this->errorDescription = $descripcion;
    }
    
    
    public function getCode()
    {
        return $this->errorCode;
    }
    
    public function getDescription()
    {
        return $this->errorDescription;
    }
    
    /**
     * @param $code
     * @return MainDescriptor
     */
    public static function mySelf($code)
    {
        return self::$errorMap[$code];
    }
    
}