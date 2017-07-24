<?php

namespace Cat\Reportes\Especificadores\Inicial;

use Cat\Models\Base;
use Cat\Models\TipoPresentismo;
use Illuminate\Foundation\Application;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Files\ExcelFile;

class Archivo extends ExcelFile
{
    protected $fileLocationOnStorage;
    
    protected $tipo;
    
    protected $fileName;
    
    public function __construct(
        Application $app,
        Excel $excel,
        TipoPresentismo $tipoPresentismo,
        $fileLocationOnStorage,
        $fileName
    ) {
        // Se carga dinamicamente el file
        $this->fileLocationOnStorage = $fileLocationOnStorage;
        $this->tipo                  = $tipoPresentismo;
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
    public function getTipo()
    {
        return $this->tipo;
    }
    
}