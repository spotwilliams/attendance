<?php

namespace Cat\Masivo\Services\Agentes;

use Cat\Masivo\Especificadores\Agentes\Archivo;
use Cat\Masivo\Especificadores\Agentes\ArchivoHandler;
use Cat\Models\Base;
use Cat\Modules\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

class Procesador extends Service
{
    /** @var  Base */
    protected $base;
    
    /** @var  UploadedFile */
    protected $file;
    
    /** @var string */
    protected $newName;
    
    
    protected $storageFolder;
    
    public function __construct(Base $base, UploadedFile $file)
    {
        $this->base          = $base;
        $this->file          = $file;
        $moment              = new \DateTime('now');
        $this->newName       = $moment->format('Y-m-d') . $moment->getTimestamp() . '.csv';
        $this->storageFolder = Storage::disk('agentes')->getDriver()->getAdapter()->getPathPrefix();
        
    }
    
    public function execute()
    {
        $this->moveFile();
        $archivo  = new Archivo(app(), App::make(Excel::class), $this->base, $this->storageFolder, $this->newName);
        
        $handler  = new ArchivoHandler($this->base, $this->storageFolder);
        
        $handler->handle($archivo);
        
    }
    
    
    private function moveFile()
    {
        $this->file->move($this->storageFolder, $this->newName);
        
    }
    
}