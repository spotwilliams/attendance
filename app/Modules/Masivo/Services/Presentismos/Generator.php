<?php

namespace Cat\Modules\Masivo\Services\Presentismos;

use Cat\Models\Base;
use Cat\Models\Turno;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileExistsException;
use Maatwebsite\Excel\Collections\RowCollection;
use Maatwebsite\Excel\Collections\SheetCollection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Readers\LaravelExcelReader;

class Generator
{
    /** @var  Turno */
    protected $turno;
    
    /** @var  Base */
    protected $base;
    
    /** @var string */
    protected $newFileName;
    
    /** @var  string */
    protected $storageFolder;
    
    /** @var string */
    protected $storageKey;
    
    /** @var string */
    protected $templateFileName;
    
    /** @var string */
    protected $templateFolder;
    
    /** @var string */
    protected $copyDestination;
    
    /** @var string */
    protected $sheetName;
    
    public function __construct(Base $base, Turno $turno)
    {
        $this->base             = $base;
        $this->turno            = $turno;
        $this->newFileName      = $this->generateName();
        $this->templateFolder   = '/templates/';
        $this->copyDestination  = 'presentismos/';
        $this->storageKey       = 'masivo';
        $this->templateFileName = 'presentismos_masivo_template.xls';
        $this->storageFolder    = Storage::disk($this->storageKey)->getDriver()->getAdapter()->getPathPrefix();
        $this->sheetName        = 'presentismos_masivo';
    }
    
    
    public function execute()
    {
        $this->generateTemplateCopy();
        $this->moveTemplateCopy();
        $excel = Excel::load($this->getFullNewFileName(), function ($reader) {
            /** @var LaravelExcelReader $reader */
            
            /** @var RowCollection $sheet */
            $reader->sheet($this->sheetName, function ($sheet) {
                /** @var Collection $operativos */
                
                $operativos = AgenteRepository::getAgentesByBaseByTurno($this->base, $this->turno);
                
                /**
                 * Encabezados
                 */
                $date = new \DateTime();
                $sheet->setCellValue('A1', 'Nombre');
                $sheet->setCellValue('B1', 'Apellido');
                $sheet->setCellValue('C1', 'CUIT');
                $sheet->setCellValue('D1', $date->format('Y-m-d'));
                $date->modify('-1day');
                $sheet->setCellValue('E1', $date->format('Y-m-d'));
                $date->modify('-1day');
                $sheet->setCellValue('F1', $date->format('Y-m-d'));
                $date->modify('-1day');
                $sheet->setCellValue('G1', $date->format('Y-m-d'));
                $date->modify('-1day');
                $sheet->setCellValue('H1', $date->format('Y-m-d'));
                /**
                 * Valores
                 */
                
                /** @var int $row */
                $row = 2;
                
                foreach ($operativos as $operativo) {
                    $sheet->setCellValue("A$row", $operativo->agente->nombre);
                    $sheet->setCellValue("B$row", $operativo->agente->apellido);
                    $sheet->setCellValue("C$row", $operativo->agente->cuit);
                    
                    $row++;
                }
            });
            
            
        })->store('xls', $this->storageFolder . $this->copyDestination);
        
    }
    
    public function getFullNewFileName()
    {
        return $this->storageFolder . $this->copyDestination . $this->newFileName;
    }
    
    public function getFileName()
    {
        return $this->newFileName;
    }
    
    private function generateTemplateCopy()
    {
        try {
            Storage::disk($this->storageKey)
                ->copy($this->templateFolder . $this->templateFileName, $this->newFileName);
        } catch (FileExistsException $e) {
            Storage::disk($this->storageKey)->delete($this->newFileName);
            $this->generateTemplateCopy();
            
        }
        
    }
    
    private function moveTemplateCopy()
    {
        try {
            Storage::disk($this->storageKey)
                ->move($this->newFileName, $this->copyDestination . $this->newFileName);
        } catch (FileExistsException $e) {
            Storage::disk($this->storageKey)
                ->delete($this->copyDestination . $this->newFileName);
            $this->moveTemplateCopy();
            
        }
    }
    
    private function generateName()
    {
        return 'template_base_' . str_replace(' ', '', $this->base->nombre) . '_turno_' . $this->turno->codigo . '.xls';
    }
    
    
    private function getSheet(LaravelExcelReader $reader, $title)
    {
        /** @var SheetCollection $sheets */
        $sheets = $reader->all();
        foreach ($sheets as $sheet) {
            if ($sheet->getTitle() === $title) {
                return $sheet;
            }
        }
        throw new \Exception('No existe la hoja solicitada');
    }
}
