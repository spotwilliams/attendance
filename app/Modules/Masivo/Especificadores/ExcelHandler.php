<?php

namespace Cat\Masivo\Especificadores;

use Cat\Models\Base;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Files\ImportHandler;

abstract class ExcelHandler implements ImportHandler
{
    /** @var Base */
    protected $base;
    
    /** @var  string */
    protected $location;
    
    public function __construct(Base $base, $locationStorage)
    {
        $this->base     = $base;
        $this->location = $locationStorage;
    }
    
    /**
     * @param $inputFileName
     * @param $prefix Prefijo para guardar en sesion
     * @return mixed
     */
    protected function generateOutFile($inputFileName, $prefix)
    {
        $name = str_replace('.csv', '', $inputFileName) . '_errores';
        session()->flash($prefix . '_new_file', $this->location . $name . '.xls');
        
        return Excel::create($name);
        
    }
}