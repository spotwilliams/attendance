<?php

namespace Cat\Reportes\Services\Presentismos;

use Cat\Reportes\Especificadores\Presentismos\ArchivoHandler;
use Cat\Reportes\Services\Common;
use Cat\Models\Base;
use Illuminate\Http\UploadedFile;

class Procesador extends Common
{
    
    public function __construct(Base $base, UploadedFile $file)
    {
        $this->handlerClass = ArchivoHandler::class;
        parent::__construct($base, $file, 'presentismos');
        
    }
    
}