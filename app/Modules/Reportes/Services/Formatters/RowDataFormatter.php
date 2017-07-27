<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 11:19
 */

namespace Cat\Modules\Reportes\Services\Formatters;

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
        $output  = [];
        $allData = $data->toArray();
        $this->extractAttribute($allData, $excludeAttributes, $excludeRelations, $output);
        
        return $output;
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