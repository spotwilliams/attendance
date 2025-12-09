<?php

namespace Cat\Modules\Masivo\Services\Presentismos;

use Cat\Modules\Masivo\Especificadores\Presentismos\ArchivoHandler;
use Cat\Modules\Masivo\Services\Common;
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
