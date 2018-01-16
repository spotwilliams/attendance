<?php

namespace Cat\Masivo\Services\Agentes;

use Cat\Masivo\Especificadores\Agentes\DuplicadoHandler;
use Cat\Masivo\Services\Common;
use Cat\Models\Base;
use Illuminate\Http\UploadedFile;

class DuplicadoProcesador extends Common
{
    
    public function __construct(Base $base, UploadedFile $file)
    {
        $this->handlerClass = DuplicadoHandler::class;
        parent::__construct($base, $file, 'agentes');
        
    }
    
}