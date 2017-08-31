<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use function GuzzleHttp\Promise\all;
use Illuminate\Database\Eloquent\Model;

abstract class  RowDataFormatter
{
    protected $allDataAvaliable
        = [
            'nombre'                      => '',
            'apellido'                    => '',
            'dni'                         => '',
            'fecha_nacimiento'            => '',
            'email'                       => '',
            'sexo'                        => '',
            'telefono'                    => '',
            'cuit'                        => '',
            'estado_civil'                => '',
            'comentario'                  => '',
            'funcion_especifica'          => '',
            'nombre_base'                 => '',
            'turno'                       => '',
            'cargo'                       => '',
            'funcion'                     => '',
            'area'                        => '',
            'gerencia'                    => '',
            'fecha_ingreso'               => '',
            'fecha_ingreso_gobierno'      => '',
            'id_sial'                     => '',
            'ficha'                       => '',
            'tipo_inscripcion'            => '',
            'monto'                       => '',
            'fecha_baja'                  => '',
            'comentario_baja'             => '',
            'tipo_contrato'               => '',
            'zz_domicilio_1_calle'        => '',
            'zz_domicilio_1_numero'       => '',
            'zz_domicilio_1_departamento' => '',
            'zz_domicilio_1_piso'         => '',
            'zz_domicilio_1_barrio'       => '',
            'zz_domicilio_1_provincia'    => '',
            'zz_domicilio_1_constituido'  => '',
            'zz_domicilio_1_libre'        => '',
            'zz_domicilio_2_calle'        => '',
            'zz_domicilio_2_numero'       => '',
            'zz_domicilio_2_departamento' => '',
            'zz_domicilio_2_piso'         => '',
            'zz_domicilio_2_barrio'       => '',
            'zz_domicilio_2_provincia'    => '',
            'zz_domicilio_2_constituido'  => '',
            'zz_domicilio_2_libre'        => '',
            'zz_estudios_1_institucion'    => '',
            'zz_estudios_1_carrera'        => '',
            'zz_estudios_1_estado'         => '',
            'zz_estudios_1_nivel'          => '',
            'zz_estudios_1_comentario'     => '',
            'zz_estudios_2_institucion'    => '',
            'zz_estudios_2_carrera'        => '',
            'zz_estudios_2_estado'         => '',
            'zz_estudios_2_nivel'          => '',
            'zz_estudios_2_comentario'     => '',
            'zz_estudios_3_institucion'    => '',
            'zz_estudios_3_carrera'        => '',
            'zz_estudios_3_estado'         => '',
            'zz_estudios_3_nivel'          => '',
            'zz_estudios_3_comentario'     => '',
        
        ];
    
    private $acentos
        = [
            '&aacute;' => 'á',
            '&eacute;' => 'é',
            '&iacute;' => 'í',
            '&oacute;' => 'ó',
            '&uacute;' => 'ú',
        ];
    
    public abstract function format(Model $model);
    
    /**
     * @param Model $data
     * @param array $excludeAttributes
     * @return array
     */
    protected function toExcelRow(Model $data, $excludeAttributes = [], $excludeRelations = [])
    {
        $allData = $data->toArray();
        $this->tieneEstudios($allData, $excludeAttributes);
        $this->tieneDomicilios($allData, $excludeAttributes);
        $result = array();
        array_walk_recursive($allData, function ($v, $k) use (&$result) {
            $v = ($v == '-1') ? 'sin datos' : $v;
            $v = ($v === true) ? 'Si' : $v;
            $v = ($v === 'F') ? 'Mujer' : ($v === 'M' ? 'Hombre' : $v);
            foreach ($this->acentos as $acento => $char) {
                $v = str_replace($acento, $char, $v);
            }
            $result[$k] = $v;
        });
        
        $resultFiltered = array_diff_key($result, $excludeAttributes);
        
        return (array_merge($this->allDataAvaliable, $resultFiltered));
        
    }
    
    protected function tieneDomicilios(&$data, $exclude)
    {
        
        if (key_exists('domicilios', $data)) {
            foreach ($data['domicilios'] as $keyDomicilio => $domicilio) {
                foreach (array_diff_key($domicilio, $exclude) as $nombre => $valor) {
                    $data['zz_domicilio_' . ($keyDomicilio + 1) . '_' . $nombre] = $valor;
                    
                }
            }
        }
        unset($data['domicilios']);
    }
    
    protected function tieneEstudios(&$data, $exclude)
    {
        
        if (key_exists('estudio', $data)) {
            foreach ($data['estudio'] as $keyEstudio => $estudio) {
                foreach (array_diff_key($estudio, $exclude) as $nombre => $valor) {
                    $data['zz_estudios_' . ($keyEstudio + 1) . '_' . $nombre] = $valor;
                    
                }
            }
        }
        unset($data['estudio']);
    }
    
    
}