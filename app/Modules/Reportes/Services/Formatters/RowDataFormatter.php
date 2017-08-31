<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use function GuzzleHttp\Promise\all;
use Illuminate\Database\Eloquent\Model;

abstract class  RowDataFormatter
{
    public abstract function format(Model $model);
    
    /**
     * @param Model $data
     * @param array $excludeAttributes
     * @return array
     */
    protected function toExcelRow(Model $data, $excludeAttributes = [], $excludeRelations = [])
    {
        $allData = $data->toArray();
        $this->tieneDomicilios($allData, $excludeAttributes);
//        dd($allData);
        $result = array();
        array_walk_recursive($allData, function ($v, $k) use (&$result) {
            $v = ($v == '-1') ? '' : $v;
            $v = ($v === true) ? 'Si' : $v;
            $v = ($v === null) ? '' : $v;
            
            
            $result[$k] = $v;
        });
        
        return array_diff_key($result, $excludeAttributes);
    }
    
    protected function tieneDomicilios(&$data, $exclude)
    {
        
        if (key_exists('domicilios', $data)) {
            foreach ($data['domicilios'] as $keyDomicilio => $domicilio) {
                foreach (array_diff_key($domicilio, $exclude) as $nombre => $valor) {
                    $data['domicilio_' . ($keyDomicilio + 1) . '_' . $nombre] = $valor;
                    
                }
            }
        }
        unset($data['domicilios']);
    }
    
    protected function extractAttribute($source, $excludeThis, $excludeRelations, &$output = [])
    {
        foreach ($source as $dataName => $dataValue) {
            if (is_array($dataValue)) {
                if (!in_array($dataName, $excludeRelations)) {
                    $this->extractAttribute($dataValue, $excludeThis, $excludeRelations, $output);
                }
            } else {
                if (!in_array($dataName, $excludeThis)) {
                    $output[$dataName] = $dataValue;
                }
            }
        }
    }
    
    
}