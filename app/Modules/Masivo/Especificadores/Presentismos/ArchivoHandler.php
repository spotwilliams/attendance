<?php

namespace Cat\Modules\Masivo\Especificadores\Presentismos;

use Cat\Modules\Masivo\Especificadores\Archivo;
use Cat\Modules\Masivo\Especificadores\ExcelHandler;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\TipoPresentismo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Collections\CellCollection;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;
use Cat\Modules\Presentismo\Services\Helpers\Facilitador as StoreService;

class ArchivoHandler extends ExcelHandler
{
    protected $listaErrores;
    
    /**
     * @param $file Archivo
     * @return mixed
     */
    public function handle($file)
    {
        
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
                        try {
                            
                            StoreService::validarDespuesGuardar($agente, $presente['tipo_presentismo'],
                                $presente['fecha']);
                        } catch (\Exception $error) {
                            $this->listaErrores[] = [
                                'cuit'             => $agente->cuit,
                                'fecha'            => $presente['fecha']->format('Y-m-d'),
                                'tipo_presentismo' => $presente['tipo_presentismo']->descripcion,
                                'mensaje'          => $error->getMessage(),
                            ];
                        }
                    }
                    
                } catch (\Exception $e) {
                    $this->listaErrores[] = [
                        'cuit'             => $row->cuit,
                        'fecha'            => 'N/A',
                        'tipo_presentismo' => 'N/A',
                        'mensaje'          => 'No se pudo procesar toda la fila',
                    ];
                }
            } else {
                break;
            }
        }
        
        $fileErrores->sheet('Errores', function ($sheet): void {
            
            $sheet->fromArray($this->listaErrores);
            
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
                
                $return [] = [
                    'fecha'            => new \DateTime($fechas[$fecha]),
                    'tipo_presentismo' => $tipoPresentismo,
                ];
            } catch (ModelNotFoundException $noEncontratoPrimerIntento) {
                try {
                    
                    $tipoPresentismo = TipoPresentismo::where('codigo', '=', $codigoPresentismo)
                        ->where('aplica', '=', 'TODOS')
                        ->firstOrFail();
                    
                    $return [] = [
                        'fecha'            => new \DateTime($fechas[$fecha]),
                        'tipo_presentismo' => $tipoPresentismo,
                    ];
                } catch (ModelNotFoundException $noEncontratoSegundoIntento) {
                    
                    $this->listaErrores[] = [
                        'cuit'             => $row->cuit,
                        'fecha'            => $fechas[$fecha],
                        'tipo_presentismo' => $codigoPresentismo,
                        'mensaje'          => 'El tipo de presentismo no se corresponde con el tipo de contrato. Intente manualmente desde la interfaz',
                    ];
                }
            }
            
        }
        
        return $return;
    }
    
    private function getFechas($file)
    {
        $sheetFechas = $this->getSheet($file, 'fechas');
        
        return $sheetFechas->first()->all();
    }
}
