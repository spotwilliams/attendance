<?php

namespace Cat\Masivo\Services\Agentes;

use Cat\Masivo\Especificadores\Agentes\ArchivoHandler;
use Cat\Masivo\Especificadores\Agentes\ModificacionHandler;
use Cat\Masivo\Services\Common;
use Cat\Models\Base;
use Illuminate\Http\UploadedFile;

class ModificacionProcesador extends Common
{
    
    public function __construct(Base $base, UploadedFile $file)
    {
        $this->handlerClass = ModificacionHandler::class;
        parent::__construct($base, $file, 'agentes');
        
    }
    
}