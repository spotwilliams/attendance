<?php

namespace Cat\Masivo\Especificadores\Agentes;

use Cat\Masivo\Especificadores\Archivo;
use Cat\Masivo\Especificadores\ExcelHandler;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Modules\Agentes\Services\Registro\Store\Personales as PersonalesStore;
use Cat\Modules\Agentes\Services\Registro\Store\Laborales as LaboralesStore;
use Cat\Modules\Agentes\Services\Registro\Store\Operativos as OperativosStore;
use Cat\Masivo\Especificadores\Mappers\Laborales as LaboralesMapper;
use Cat\Masivo\Especificadores\Mappers\Operativos as OperativosMapper;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Collections\CellCollection;
use Cat\Masivo\Especificadores\Mappers\Personales as PersonalesMapper;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class ArchivoHandler extends ExcelHandler
{
    
    public function handle($file)
    {
        /** @var Archivo $file */
        
        $listaErrores = [];
        
        /** @var Base $base */
        $base = $file->getBase();
        
        /** @var LaravelExcelWriter $fileErrores */
        $fileErrores = $this->generateOutFile($file->getFileName(), 'agentes');
        
        $file->each(function ($row) use ($base, &$listaErrores) {
            try {
                $agente = $this->handlePersonales($row);
                $this->handleLaborales($row, $agente);
                $this->handleOperativos($row, $agente, $base);
                
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
    
    
    private function handleLaborales(CellCollection $row, Agente $agente)
    {
        $input        = LaboralesMapper::toInput($row);
        $storeService = new LaboralesStore($agente, $input);
        
        $storeService->execute();
    }
    
    private function handleOperativos(CellCollection $row, Agente $agente, Base $base)
    {
        $input        = OperativosMapper::toInput($row, $agente, $base);
        $storeService = new OperativosStore($input);
        
        $storeService->execute();
    }
    
}