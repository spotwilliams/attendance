<?php

namespace Cat\Masivo\Especificadores\Presentismos;

use Cat\Masivo\Especificadores\Archivo;
use Cat\Masivo\Especificadores\ExcelHandler;
use Cat\Models\Agente;
use Cat\Models\Base;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Collections\CellCollection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Files\ImportHandler;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class ArchivoHandler extends ExcelHandler
{
    /**
     * @param $file Archivo
     * @return mixed
     */
    public function handle($file)
    {
        
        $listaErrores = [];
        
        /** @var Base $base */
        $base = $file->getBase();
        
        /** @var LaravelExcelWriter $fileErrores */
        $fileErrores = $this->generateOutFile($file->getFileName());
        
        $file->each(function ($row) use ($base, &$listaErrores) {
            try {
                $agente = $this->handlePersonales($row);
                
            } catch (\Exception $e) {
                $listaErrores[] = $row->toArray();
            }
        });
        
        $fileErrores->sheet('Errores', function ($sheet) use ($listaErrores) {
            
            $sheet->fromArray($listaErrores);
            
        })->store('xls', $this->location, true);
        
        Flash::warning('Se finaliz&oacute; el proceso de importaci&oacute;n');
        
    }
    
    private function handlePersonales(CellCollection $row)
    {
        $agente       = new Agente(PersonalesMapper::toAgenteInput($row));
        $storeService = new PersonalesStore(
            $agente,
            PersonalesMapper::toDomicilioInput($row),
            PersonalesMapper::toEstudioInput($row)
        );
        
        return $storeService->execute();
    }
    
    
    
}