<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use Illuminate\Database\Eloquent\Model;

class Presentismo extends RowDataFormatter
{
    public function toExcelRow(Model $data, $attributes = ['*'], $relations = ['*' => '*'])
    {
    
    }
    
}