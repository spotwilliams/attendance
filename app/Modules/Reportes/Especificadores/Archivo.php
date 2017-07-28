<?php

namespace Cat\Reportes\Especificadores;

use Cat\Models\Base;
use Illuminate\Foundation\Application;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Files\ExcelFile;

class Archivo extends ExcelFile
{
    protected $fileLocationOnStorage;
    
    protected $base;
    
    protected $fileName;
    
    public function __construct(Application $app, Excel $excel, Base $base, $fileLocationOnStorage, $fileName)
    {
        // Se carga dinamicamente el file
        $this->fileLocationOnStorage = $fileLocationOnStorage;
        $this->base                  = $base;
        $this->fileName              = $fileName;
        
        parent::__construct($app, $excel);
        
    }
    
    
    public function getFile()
    {
        return $this->fileLocationOnStorage . $this->fileName;
    }
    
    public function getFilters()
    {
        return [
            'chunk',
        ];
    }
    
    public function getFileName()
    {
        return $this->fileName;
    }
    
    /**
     * @return Base
     */
    public function getBase()
    {
        return $this->base;
    }
    
}