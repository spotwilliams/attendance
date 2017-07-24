<?php

namespace Cat\Reportes\Services\Agentes;

use Cat\Reportes\Especificadores\Agentes\ArchivoHandler;
use Cat\Reportes\Services\Common;
use Cat\Models\Base;
use Illuminate\Http\UploadedFile;

class Procesador extends Common
{
    
    public function __construct(Base $base, UploadedFile $file)
    {
        $this->handlerClass = ArchivoHandler::class;
        parent::__construct($base, $file, 'agentes');
        
    }
    
}