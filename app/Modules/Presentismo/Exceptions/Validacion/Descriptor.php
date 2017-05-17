<?php

namespace Cat\Modules\Presentismo\Exceptions\Validacion;

class Descriptor
{
    const CONTRATO_INACTIVO    = 1000;
    const CONTRATO_NO_LOCACION = 2000;
    const SIN_DIAS_DISPONIBLES = 3000;
    
    private        $errorCode;
    private        $errorDescription;
    private static $errorMap;
    
    private function __construct($code, $descripcion)
    {
        $this->errorCode        = $code;
        $this->errorDescription = $descripcion;
    }
    
    public static function contratoInactivo()
    {
        if (!isset(self::$errorMap[Descriptor::CONTRATO_INACTIVO])) {
            self::$errorMap[Descriptor::CONTRATO_INACTIVO]
                = new Descriptor(Descriptor::CONTRATO_INACTIVO, 'Contrato inactivo');
        }
        
        return self::$errorMap[Descriptor::CONTRATO_INACTIVO];
    }
    
    public static function noEsContratoLocacion()
    {
        if (!isset(self::$errorMap[Descriptor::CONTRATO_NO_LOCACION])) {
            self::$errorMap[Descriptor::CONTRATO_NO_LOCACION]
                = new Descriptor(Descriptor::CONTRATO_NO_LOCACION, 'El contrato no es de locacion');
        }
        
        return self::$errorMap[Descriptor::CONTRATO_NO_LOCACION];
    }
    
    public static function noTieneDiasDisponibles()
    {
        if (!isset(self::$errorMap[Descriptor::SIN_DIAS_DISPONIBLES])) {
            self::$errorMap[Descriptor::SIN_DIAS_DISPONIBLES]
                = new Descriptor(Descriptor::SIN_DIAS_DISPONIBLES, 'No tiene dias disponibles para el tipo de ausencia');
        }
        
        return self::$errorMap[Descriptor::SIN_DIAS_DISPONIBLES];
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
     * @return Descriptor
     */
    public static function mySelf($code)
    {
        return self::$errorMap[$code];
    }
    
}