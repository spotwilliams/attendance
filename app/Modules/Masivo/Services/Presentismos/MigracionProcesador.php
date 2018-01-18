<?php

namespace Cat\Masivo\Services\Presentismos;

use Cat\Masivo\Especificadores\Presentismos\MigracionHandler;
use Cat\Masivo\Services\Common;
use Cat\Models\Base;
use Illuminate\Http\UploadedFile;

class MigracionProcesador extends Common
{
    
    public function __construct(Base $base, UploadedFile $file)
    {
        $this->handlerClass = MigracionHandler::class;
        parent::__construct($base, $file, 'presentismos');
        
    }
    
}