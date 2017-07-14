<?php

namespace Cat\Masivo\Services\Inicial;

use Cat\Masivo\Especificadores\Inicial\Archivo;
use Cat\Masivo\Especificadores\Inicial\ArchivoHandler;
use Cat\Models\TipoPresentismo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

class Procesador
{
    
    /** @var  TipoPresentismo */
    protected $tipoPresentismo;
    
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
    
    public function __construct(TipoPresentismo $t, UploadedFile $file, $storageKey)
    {
        $this->tipoPresentismo = $t;
        $this->file            = $file;
        $moment                = new \DateTime('now');
        $this->newName         = $moment->format('Y-m-d') . $moment->getTimestamp() . '.xlsx';
        $this->storageKey      = $storageKey;
        $this->storageFolder   = Storage::disk($this->storageKey)->getDriver()->getAdapter()->getPathPrefix();
        $this->handlerClass    = ArchivoHandler::class;
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
            $this->tipoPresentismo,
            $this->storageFolder,
            $this->newName
        );
        
        $handler = new $this->handlerClass($this->tipoPresentismo, $this->storageFolder);
        
        $handler->handle($this->archivo);
        
        $this->deleteFile();
    }
    
    public function deleteFile()
    {
        Storage::disk($this->storageKey)->delete($this->newName);
    }
    
}