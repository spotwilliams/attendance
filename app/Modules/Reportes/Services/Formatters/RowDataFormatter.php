<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use function GuzzleHttp\Promise\all;
use Illuminate\Database\Eloquent\Model;

abstract class  RowDataFormatter
{
    /** @var  array */
    protected $encabezado;
    
    protected $acentos
        = [
            '&aacute;' => 'á',
            '&eacute;' => 'é',
            '&iacute;' => 'í',
            '&oacute;' => 'ó',
            '&uacute;' => 'ú',
        ];
    
    public abstract function format(Model $model);
    
    public function getEncabezado()
    {
        return $this->encabezado;
    }
    protected function cleanAcentos($v)
    {
        foreach ($this->acentos as $acento => $char) {
            $v = str_replace($acento, $char, $v);
        }
        
        return $v;
    }
}