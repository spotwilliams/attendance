<?php

namespace Cat\Reportes\Especificadores\Mappers;

use Cat\Reportes\Helpers\DataCleaner;
use Maatwebsite\Excel\Collections\CellCollection;

class Personales
{
    
    public static function toAgenteInput(CellCollection $collection)
    {
        return [
            'nombre'           => DataCleaner::cleanPossibleEmptyValue($collection->nombre),
            'apellido'         => DataCleaner::cleanPossibleEmptyValue($collection->apellido),
            'dni'              => DataCleaner::cleanPossibleEmptyValue($collection->dni),
            'cuit'             => DataCleaner::cleanPossibleEmptyValue($collection->cuit),
            'fecha_nacimiento' => DataCleaner::cleanPossibleEmptyDate($collection->fecha_nacimiento),
            'email'            => DataCleaner::cleanPossibleEmptyValue($collection->email),
            'telefono'         => DataCleaner::cleanPossibleEmptyValue($collection->telefono),
            'sexo'             => DataCleaner::cleanPossibleEmptyValue($collection->sexo),
            'estado_civil'     => DataCleaner::cleanPossibleEmptyValue($collection->estado_civil),
        ];
    }
    
    public static function toEstudioInput(CellCollection $collection)
    {
        return [
            'carrera'      => [DataCleaner::cleanPossibleEmptyValue($collection->estudio_carrera)],
            'institucion'  => [DataCleaner::cleanPossibleEmptyValue($collection->estudio_institucion)],
            'estado'       => [DataCleaner::cleanPossibleEmptyValue($collection->estudio_estado)],
            'nivelestudio' => [DataCleaner::cleanPossibleEmptyValue($collection->estudio_nivel)],
        ];
    }
    
    public static function toDomicilioInput(CellCollection $collection)
    {
        return [
    
            'calle'        => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_calle)],
            'numero'       => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_numero)],
            'departamento' => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_departamento)],
            'piso'         => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_piso)],
            'barrio'       => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_barrio)],
            'provincia'    => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_provincia)],
            'constituido'  => [DataCleaner::cleanPossibleEmptyValue((strtoupper($collection->domicilio_constituido) == 'SI') ? true : false)],
            'libre'        => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_otro)],
        
        ];
    }
}