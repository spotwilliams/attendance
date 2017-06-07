<?php

namespace Cat\Masivo\Especificadores\Presentismos;

use Cat\Masivo\Especificadores\Archivo;
use Cat\Masivo\Especificadores\ExcelHandler;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\TipoPresentismo;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Collections\CellCollection;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;
use Cat\Modules\Presentismo\Services\Helpers\Facilitador as StoreService;

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
        $fileErrores = $this->generateOutFile($file->getFileName(), 'presentismos');
        
        $file->each(function ($row) use ($base, &$listaErrores) {
            try {
                $agente           = $this->getAgente($row);
                $listaPresentismo = $this->getDatesWithPresentismos($row);
                
                foreach ($listaPresentismo as $presente) {
                    StoreService::validarDespuesGuardar($agente, $presente['tipo_presentismo'], $presente['fecha']);
                }
            } catch (\Exception $e) {
                $listaErrores[] = $row->toArray();
            }
        });

        $fileErrores->sheet('Errores', function ($sheet) use ($listaErrores) {
            
            $sheet->fromArray($listaErrores);
            
        })->store('xls', $this->location, true);
        
        Flash::warning('Se finaliz&oacute; el proceso de importaci&oacute;n');
        
    }
    
    private function getAgente(CellCollection $row)
    {
        return Agente::where('dni', '=', $row->dni)
            ->where('cuit', '=', $row->cuit)
            ->firstOrFail();
    }
    
    private function getDatesWithPresentismos(CellCollection $row)
    {
        $data = $row->all();
        unset($data['dni']);
        unset($data['cuit']);
        
        $return = [];
        foreach ($data as $fecha => $codigoPresentismo) {
            $fecha     = str_replace('_', '-', $fecha);
            $return [] = [
                'fecha'            => new \DateTime($fecha),
                'tipo_presentismo' => TipoPresentismo::where('codigo', '=', $codigoPresentismo)->firstOrFail(),
            ];
        }
        
        return $return;
    }
    
}