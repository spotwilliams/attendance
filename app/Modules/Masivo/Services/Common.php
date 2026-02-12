<?php

namespace Cat\Modules\Masivo\Services;

use Cat\Modules\Masivo\Especificadores\Archivo;
use Cat\Models\Base;
use Cat\Modules\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

abstract class Common extends Service
{
    /** @var  Base */
    protected $base;
    
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
    
    /** @var string */
    protected $storageKey;
    
    public function __construct(Base $base, UploadedFile $file, $storageKey)
    {
        $this->base          = $base;
        $this->file          = $file;
        $moment              = new \DateTime('now');
        $this->newName       = $moment->format('Y-m-d') . $moment->getTimestamp() . '.xlsx';
        $this->storageKey    = $storageKey;
        $this->storageFolder = Storage::disk($this->storageKey)->path('');
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
        
        $this->deleteFile();
    }
    
    public function deleteFile()
    {
        Storage::disk($this->storageKey)->delete($this->newName);
    }
    
}
