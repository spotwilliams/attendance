<?php

namespace Cat\Masivo\Especificadores\Mappers;

use Maatwebsite\Excel\Collections\CellCollection;

class Personales
{
    
    public static function toAgenteInput(CellCollection $collection)
    {
        return [
            'nombre'           => $collection->nombre,
            'apellido'         => $collection->apellido,
            'dni'              => $collection->dni,
            'cuit'             => $collection->cuit,
            'fecha_nacimiento' => $collection->fecha_nacimiento,
            'email'            => $collection->email,
            'telefono'         => $collection->telefono,
            'sexo'             => $collection->sexo,
            'estado_civil'     => $collection->estado_civil,
        ];
    }
    
    public static function toEstudioInput(CellCollection $collection)
    {
        return [
            'carrera'      => [$collection->estudio_carrera],
            'institucion'  => [$collection->estudio_institucion],
            'estado'       => [$collection->estudio_estado],
            'nivelestudio' => [$collection->estudio_nivel],
        ];
    }
    
    public static function toDomicilioInput(CellCollection $collection)
    {
        return [
            
            'calle'        => [$collection->domicilio_calle],
            'numero'       => [$collection->domicilio_numero],
            'departamento' => [$collection->domicilio_departamento],
            'piso'         => [$collection->domicilio_piso],
            'barrio'       => [$collection->domicilio_barrio],
            'provincia'    => [$collection->domicilio_provincia],
            'constituido'  => [(strtoupper($collection->domicilio_constituido) == 'SI') ? 1 : 0],
            'libre'        => [$collection->domicilio_otro],
        
        ];
    }
}