<?php

namespace Cat\Modules\Presentismo\Exceptions;

use Cat\Exceptions\MainDescriptor;
use Cat\Models\Base;
use Cat\Models\Periodo;
use Cat\Models\TipoPresentismo;
use Cat\Models\Turno;

class Descriptor extends MainDescriptor
{
    const CONTRATO_INACTIVO                  = 1000;
    const CONTRATO_NO_LOCACION               = 2000;
    const SIN_DIAS_DISPONIBLES               = 3000;
    const PERIODO_CERRADO                    = 4000;
    const BASE_TURNO_SIN_PERIODO             = 4001;
    const PERIODO_ABIERTO_PARA_CALCULAR      = 4002;
    const TIPO_PRESENTISMO_SIN_DIAS_CARGADOS = 5000;
    const TIPO_PRESENTISMO_NO_SE_JUSTIFICA   = 6000;
    const TIPO_PRESENTISMO_NO_SE_INJUSTIFICA = 7000;
    const ESTADO_CONTRATO_EN_COMISION        = 9000;
    const FECHA_FUTURA                       = 8000;
    
    
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
                = new Descriptor(Descriptor::SIN_DIAS_DISPONIBLES,
                'No tiene dias disponibles para el tipo de ausencia');
        }
        
        return self::$errorMap[Descriptor::SIN_DIAS_DISPONIBLES];
    }
    
    public static function presentismoSinDiasConfigurados(TipoPresentismo $tipoPresentismo)
    {
        if (!isset(self::$errorMap[Descriptor::TIPO_PRESENTISMO_SIN_DIAS_CARGADOS])) {
            self::$errorMap[Descriptor::TIPO_PRESENTISMO_SIN_DIAS_CARGADOS]
                = new Descriptor(Descriptor::TIPO_PRESENTISMO_SIN_DIAS_CARGADOS,
                'EL tipo de presentismo "' . $tipoPresentismo->codigo . '" no tiene dias disponibles configurados');
        }
        
        return self::$errorMap[Descriptor::TIPO_PRESENTISMO_SIN_DIAS_CARGADOS];
    }
    
    public static function periodoCerradoParaBase()
    {
        if (!isset(self::$errorMap[Descriptor::PERIODO_CERRADO])) {
            self::$errorMap[Descriptor::PERIODO_CERRADO]
                = new Descriptor(Descriptor::PERIODO_CERRADO,
                'La fecha pertenece a un periodo ya facturado para este agente');
        }
        
        return self::$errorMap[Descriptor::PERIODO_CERRADO];
    }
    
    /**
     * @return self
     */
    public static function periodoAbiertoParaCalcular()
    {
        if (!isset(self::$errorMap[Descriptor::PERIODO_ABIERTO_PARA_CALCULAR])) {
            self::$errorMap[Descriptor::PERIODO_ABIERTO_PARA_CALCULAR]
                = new Descriptor(Descriptor::PERIODO_ABIERTO_PARA_CALCULAR,
                'El periodo seleccionado es el actual y no puede ser usado para calcular los montos.');
        }
        
        return self::$errorMap[Descriptor::PERIODO_ABIERTO_PARA_CALCULAR];
    }
    
    public static function fechaFutura(TipoPresentismo $tipo)
    {
        if (!isset(self::$errorMap[Descriptor::FECHA_FUTURA])) {
            self::$errorMap[Descriptor::FECHA_FUTURA]
                = new Descriptor(Descriptor::FECHA_FUTURA,
                "'$tipo->codigo' no puede asignarse en una fecha posterior a la de hoy.");
        }
        
        return self::$errorMap[Descriptor::FECHA_FUTURA];
    }
    
    public static function presentismoNoSeJustifica()
    {
        if (!isset(self::$errorMap[Descriptor::TIPO_PRESENTISMO_NO_SE_JUSTIFICA])) {
            self::$errorMap[Descriptor::TIPO_PRESENTISMO_NO_SE_JUSTIFICA]
                = new Descriptor(Descriptor::TIPO_PRESENTISMO_NO_SE_JUSTIFICA,
                'El tipo de presentismo no se puede justificar');
        }
        
        return self::$errorMap[Descriptor::TIPO_PRESENTISMO_NO_SE_JUSTIFICA];
    }
    
    public static function presentismoNoSeInjustifica()
    {
        if (!isset(self::$errorMap[Descriptor::TIPO_PRESENTISMO_NO_SE_INJUSTIFICA])) {
            self::$errorMap[Descriptor::TIPO_PRESENTISMO_NO_SE_INJUSTIFICA]
                = new Descriptor(Descriptor::TIPO_PRESENTISMO_NO_SE_INJUSTIFICA,
                'El tipo de presentismo no se puede injustificar');
        }
        
        return self::$errorMap[Descriptor::TIPO_PRESENTISMO_NO_SE_INJUSTIFICA];
    }
    
    public static function baseTurnoSinPeriodo(Periodo $periodo, Base $base, Turno $turno)
    {
        if (!isset(self::$errorMap[Descriptor::BASE_TURNO_SIN_PERIODO])) {
            $fC  = (new \DateTime($periodo->fecha_comienzo))->format('d/m/Y');
            $fF  = (new \DateTime($periodo->fecha_fin))->format('d/m/Y');
            $msg = "El periodo comprendido entre $fC y $fF no existe para la base $base->nombre y turno $turno->codigo.";
            
            self::$errorMap[Descriptor::BASE_TURNO_SIN_PERIODO]
                = new Descriptor(Descriptor::BASE_TURNO_SIN_PERIODO, $msg);
        }
        
        return self::$errorMap[Descriptor::BASE_TURNO_SIN_PERIODO];
    }
    
    
    public static function estadoContratoEnComision(TipoPresentismo $tipo)
    {
        if (!isset(self::$errorMap[Descriptor::ESTADO_CONTRATO_EN_COMISION])) {
            self::$errorMap[Descriptor::ESTADO_CONTRATO_EN_COMISION]
                = new Descriptor(Descriptor::ESTADO_CONTRATO_EN_COMISION,
                'Los agentes en comisión solo pueden tener presentismo \'EX\'');
        }
        
        return self::$errorMap[Descriptor::ESTADO_CONTRATO_EN_COMISION];
    }
}