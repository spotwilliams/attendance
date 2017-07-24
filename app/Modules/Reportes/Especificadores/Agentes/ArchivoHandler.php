<?php

namespace Cat\Reportes\Especificadores\Agentes;

use Cat\Reportes\Especificadores\Archivo;
use Cat\Reportes\Especificadores\ExcelHandler;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Modules\Agentes\Services\Registro\Store\Personales as PersonalesStore;
use Cat\Modules\Agentes\Services\Registro\Store\Laborales as LaboralesStore;
use Cat\Modules\Agentes\Services\Registro\Store\Operativos as OperativosStore;
use Cat\Modules\Agentes\Services\Registro\Destroy\Forced\Personales as PersonalesDestroy;
use Cat\Modules\Agentes\Services\Registro\Destroy\Forced\Laborales as LaboralesDestroy;
use Cat\Modules\Agentes\Services\Registro\Destroy\Forced\Operativos as OperativosDestroy;
use Cat\Reportes\Especificadores\Mappers\Laborales as LaboralesMapper;
use Cat\Reportes\Especificadores\Mappers\Operativos as OperativosMapper;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Collections\CellCollection;
use Cat\Reportes\Especificadores\Mappers\Personales as PersonalesMapper;
use Maatwebsite\Excel\Collections\RowCollection;
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
        
        /** @var RowCollection $sheet */
        $sheet = $this->getSheet($file, 'procesado');
        
        
        for ($i = 0; $i < $sheet->count(); $i++) {
            /** @var CellCollection $row */
            $row = $sheet->get($i);
            
            try {
                if ($row->cuit !== 'empty') {
                    $agente = $this->handlePersonales($row);
                    $this->handleLaborales($row, $agente);
                    $this->handleOperativos($row, $agente, $base);
//                    Log::info($row->cuit);
                } else {
                    break;
                }
            } catch (\Exception $e) {
//                Log::error($e->getMessage());
                $this->clearPossibleMistakes($row);
                
                $listaErrores[] = [
                    '#'                => $i + 2,
                    'nombre'           => $row->nombre,
                    'apellido'         => $row->apellido,
                    'dni'              => $row->dni,
                    'cuit'             => $row->cuit,
                    'technical_reason' => $e->getMessage(),
                ];
            }
        }
        
        
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
//        $base         = Base::findOrFail((string)round($row->base));
        $input        = OperativosMapper::toInput($row, $agente, $base);
        $storeService = new OperativosStore($input);
        
        $storeService->execute();
    }
    
    /**
     * En caso de error, se trata de borrar cualquier cosa que se haya genereado
     * @param CellCollection $cell
     */
    private function clearPossibleMistakes(CellCollection $cell)
    {
        $agente = Agente::where('cuit', '=', $cell->cuit)
            ->first();
        
        if ($agente !== null) {
            
            $destroy = [
                LaboralesDestroy::class,
                OperativosDestroy::class,
                PersonalesDestroy::class,
            ];
            
            foreach ($destroy as $service) {
                try {
                    (new $service($agente))->execute();
                } catch (\Exception $e) {
                }
            }
        }
    }
}