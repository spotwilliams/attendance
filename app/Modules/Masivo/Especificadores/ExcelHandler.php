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
    
    
    protected function generateOutFile($inputFileName)
    {
        $name = str_replace('.csv', '', $inputFileName) . '_errores';
        session()->flash('new_file', $this->location . $name . '.xls');
        
        return Excel::create($name);
        
    }
}