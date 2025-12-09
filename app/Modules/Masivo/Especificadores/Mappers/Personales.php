<?php

namespace Cat\Modules\Masivo\Especificadores\Mappers;

use Cat\Modules\Masivo\Helpers\DataCleaner;
use Maatwebsite\Excel\Collections\CellCollection;

class Personales
{
    
    public static function toAgenteInput(CellCollection $collection)
    {
        return [
            'nombre'              => DataCleaner::cleanPossibleEmptyValue($collection->nombre),
            'apellido'            => DataCleaner::cleanPossibleEmptyValue($collection->apellido),
            'dni'                 => DataCleaner::cleanPossibleEmptyValue($collection->dni),
            'cuit'                => DataCleaner::cleanPossibleEmptyValue($collection->cuit),
            'fecha_nacimiento'    => DataCleaner::cleanPossibleEmptyDate($collection->fecha_nacimiento),
            'email'               => DataCleaner::cleanPossibleEmptyValue($collection->email),
            'email_gobierno'      => DataCleaner::cleanPossibleEmptyValue($collection->email_gobierno),
            'telefono_particular' => DataCleaner::cleanPossibleEmptyValue($collection->telefono_particular),
            'telefono_casa'       => DataCleaner::cleanPossibleEmptyValue($collection->telefono_casa),
            'telefono_ht'         => DataCleaner::cleanPossibleEmptyValue($collection->telefono_ht),
            'sexo'                => DataCleaner::cleanPossibleEmptyValue($collection->sexo),
            'estado_civil'        => DataCleaner::cleanPossibleEmptyValue($collection->estado_civil),
            'profesion'           => DataCleaner::cleanPossibleEmptyValue($collection->profesion),
            'observacion'         => DataCleaner::cleanPossibleEmptyValue($collection->observacion),
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
            
            'calle'         => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_calle)],
            'numero'        => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_numero)],
            'departamento'  => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_departamento)],
            'piso'          => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_piso)],
            'barrio'        => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_barrio)],
            'provincia'     => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_provincia)],
            'constituido'   => [DataCleaner::cleanPossibleEmptyValue((strtoupper($collection->domicilio_constituido) == 'SI') ? true : false)],
            'libre'         => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_otro)],
            'codigo_postal' => [DataCleaner::cleanPossibleEmptyValue($collection->domicilio_codigo_postal)],
        ];
    }
}
