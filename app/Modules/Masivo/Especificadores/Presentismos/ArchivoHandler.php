<?php

namespace Cat\Masivo\Especificadores\Presentismos;

use Cat\Masivo\Especificadores\Archivo;
use Cat\Masivo\Especificadores\ExcelHandler;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\TipoPresentismo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        
        
        $fechas = $this->getFechas($file);
        
        /** @var RowCollection $sheet */
        $sheet = $this->getSheet($file, 'procesado');
        
        
        for ($i = 0; $i < $sheet->count(); $i++) {
            /** @var CellCollection $row */
            $row = $sheet->get($i);
            if ($row->cuit !== 'empty') {
                
                try {
                    $agente           = $this->getAgente($row);
                    $listaPresentismo = $this->getDatesWithPresentismos($row, $agente, $fechas);
                    
                    foreach ($listaPresentismo as $presente) {
                        StoreService::validarDespuesGuardar($agente, $presente['tipo_presentismo'], $presente['fecha']);
                    }
                } catch (\Exception $e) {
                    foreach ($row->toArray() as $key => $item) {
                        if (isset($fechas[$key])) {
                            
                            $error [$fechas[$key]] = $item;
                        } else {
                            $error[$key] = $item;
                        }
                    }
                    $listaErrores[] = $error;
                }
            } else {
                break;
            }
        }
        
        $fileErrores->sheet('Errores', function ($sheet) use ($listaErrores) {
            
            $sheet->fromArray($listaErrores);
            
        })->store('xls', $this->location, true);
        
        Flash::warning('Se finaliz&oacute; el proceso de importaci&oacute;n');
        
    }
    
    private function getAgente(CellCollection $row)
    {
        return Agente::where('cuit', '=', $row->cuit)
            ->with('contrato.tipoContrato')
            ->firstOrFail();
    }
    
    private function getDatesWithPresentismos(CellCollection $row, Agente $agente, $fechas)
    {
        $data = $row->all();
        unset($data['nombre']);
        unset($data['apellido']);
        unset($data['cuit']);
        $return = [];
        foreach ($data as $fecha => $codigoPresentismo) {
            
            try {
                $tipoPresentismo = TipoPresentismo::where('codigo', '=', $codigoPresentismo)
                    ->where('aplica', '=', $agente->contrato->TipoContrato->codigo)
                    ->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $tipoPresentismo = TipoPresentismo::where('codigo', '=', $codigoPresentismo)
                    ->where('aplica', '=', 'TODOS')
                    ->firstOrFail();
            }
            $return [] = [
                'fecha'            => new \DateTime($fechas[$fecha]),
                'tipo_presentismo' => $tipoPresentismo,
            ];
        }
        
        return $return;
    }
    
    private function getFechas($file)
    {
        $sheetFechas = $this->getSheet($file, 'fechas');
        
        return $sheetFechas->first()->all();
    }
}