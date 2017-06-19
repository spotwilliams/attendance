<?php

namespace Cat\Masivo\Services;

use Cat\Masivo\Especificadores\Archivo;
use Cat\Models\Base;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Cat\Modules\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

class Manager extends Service
{
    /** @var  Base */
    protected $base;
    
    /** @var  Periodo */
    protected $periodo;
    
    /** @var  Turno */
    protected $turno;
    
    /** @var  UploadedFile */
    protected $file;
    
    /** @var string */
    protected $newName;
    
    /** @var  string */
    protected $storageFolder;
    
    /** @var Archivo */
    protected $archivo;
    
    /** @var  string */
    protected $handlerClass;
    
    
    public function __construct(Base $base, Periodo $periodo, Turno $turno, UploadedFile $file)
    {
        $this->base          = $base;
        $this->periodo       = $periodo;
        $this->turno         = $turno;
        $this->file          = $file;
        $moment              = new \DateTime('now');
        $this->newName       = $moment->format('Y-m-d') . $moment->getTimestamp() . '.xlsx';
        $this->storageFolder = Storage::disk('haberes')
            ->getDriver()
            ->getAdapter()
            ->getPathPrefix();
        
    }
    
    protected function moveFile()
    {
        $this->file->move($this->storageFolder, $this->newName);
    }
    
    public function execute()
    {
        
        $this->moveFile();
        
        $this->archivo = new Archivo(
            app(),
            App::make(Excel::class),
            $this->base,
            $this->storageFolder,
            $this->newName
        );
        
        $handler = new $this->handlerClass($this->base, $this->storageFolder);
        
        $handler->handle($this->archivo);
        
    }
    
}