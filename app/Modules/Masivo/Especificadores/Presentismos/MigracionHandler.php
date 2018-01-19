<?php

namespace Cat\Masivo\Especificadores\Presentismos;

use Carbon\Carbon;
use Cat\Masivo\Especificadores\Archivo;
use Cat\Masivo\Especificadores\ExcelHandler;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Repositories\PeriodoRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Collections\CellCollection;
use Maatwebsite\Excel\Collections\RowCollection;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;
use Cat\Modules\Presentismo\Services\Helpers\Facilitador as StoreService;
use Cat\Modules\Presentismo\Services\Registro\Registro;

class MigracionHandler extends ExcelHandler
{
    protected $listaErrores;
    
    /**
     * @param $file Archivo
     * @return mixed
     */
    public function handle($file)
    {
        ini_set('max_execution_time', 18000);
        ini_set('memory_limit', '-1');
        
        
        /** @var LaravelExcelWriter $fileErrores */
        $fileErrores = $this->generateOutFile($file->getFileName(), 'presentismos');
        
        $file->noHeading(true);
        
        /** @var RowCollection $sheet */
        $sheet = $this->getSheet($file, 'Historial Agente');
        
        $fechas = $this->getFechas($sheet->get(0));
        
        $idErrorAgente = 0;
        $this->createErrorRow($fechas, $idErrorAgente);
        for ($i = 1; $i < $sheet->count(); $i++) {
            /** @var CellCollection $row */
            $row = $sheet->get($i);
            try {
                /** @var Agente $agente */
                $agente = $this->getAgente($row[1]);
                for ($j = 2; $j < count($row); $j++) {
                    if ($row[$j]) {
                        try {
                            
                            /** @var TipoPresentismo $tipoPresentismo */
                            $tipoPresentismo = TipoPresentismo::where('codigo', '=', $row[$j])
                                ->firstOrFail();
                            
                            $tipoPresentismo->injustificado = false;
                            // Con validaciones
//                            StoreService::validarDespuesGuardar($agente, $tipoPresentismo, $fechas[$j]);
                            
                            // Sin validaciones
                            /** @var Registro $servicio */
                            $servicio = new Registro($agente, $tipoPresentismo, $fechas[$j]);
                            $servicio->execute();
                        } catch (ModelNotFoundException $e) {
                            
                            
                            if (isset($this->listaErrores[$idErrorAgente]) and ($this->listaErrores[$idErrorAgente]['cuit'] !== $row[1])) {
                                $idErrorAgente++;
                            }
                            
                            $this->listaErrores[$idErrorAgente]['agente'] = $row[0];
                            $this->listaErrores[$idErrorAgente]['cuit']   = $row[1];
                            $this->listaErrores[$idErrorAgente]['error_agente']   = '';
                            $this->listaErrores[$idErrorAgente][($fechas[$j])->format('d-m-Y')]
                                                                          = 'Tipo: ' . $row[$j] . '. Error: el tipo de presentismo no esta registrado';
                        }
                        
                    }
                }
            } catch (ModelNotFoundException $e) {
                if (isset($this->listaErrores[$idErrorAgente]) and ($this->listaErrores[$idErrorAgente]['cuit'] !== $row[1])) {
                    $idErrorAgente++;
                    
                }
                $this->listaErrores[$idErrorAgente] = [
                    'agente'       => $row[0],
                    'cuit'         => $row[1],
                    'error_agente' => 'No se encontro el agente con ese CUIT',
                ];
                $idErrorAgente++;
                
            }
        }
        
        $fileErrores->sheet('Errores', function ($sheet) use ($fechas) {
            
            $sheet->fromArray($this->createErrorList($fechas));
            
        })->store('xls', $this->location, true);
        
        Flash::warning('Se finaliz&oacute; el proceso de importaci&oacute;n');
        
    }
    
    
    private function createErrorList($fechas)
    {
        $errores = [];
        $index   = 0;
        foreach ($this->listaErrores as $error) {
            $aux =array_merge($this->createErrorRow($fechas, $index++), $error);
            unset($aux[0]);
            $errores[] = $aux;
        }
        
        return $errores;
    }
    
    private function createErrorRow($fechas, $index)
    {
        $return                         = [];
        $return[$index]['agente']       = '';
        $return[$index]['cuit']         = '';
        $return[$index]['error_agente'] = '';
        /** @var \DateTime $f */
        foreach ($fechas as $f) {
            if ($f->format('d-m-Y') !== '01-01-1900') {
                $return[$f->format('d-m-Y')] = '';
            }
        }
        
        return $return;
    }
    
    private function getAgente($cuit)
    {
        return Agente::where('cuit', '=', str_replace('-', '', $cuit))
            ->with('contrato.tipoContrato')
            ->firstOrFail();
    }

    private function getFechas(CellCollection $collection)
    {
        $fechas = [];
        
        foreach ($collection as $indice => $dato) {
            $delimiter = '/';
            $date      = explode($delimiter, $dato);
            if (!is_array($date) or count($date) != 3) {
                $fechas[$indice] = new \DateTime('1900-01-01');
            } else {
                $value           = $date[2] . '-' . $date[1] . '-' . $date[0];
                $fechas[$indice] = new \DateTime($value);
                $this->getOrCreatePeriodoActivo($fechas[$indice]);
            }
        }
        
        return $fechas;
    }
    
    public static function getOrCreatePeriodoActivo(\DateTime $fecha = null)
    {
        $periodo = Periodo::findActivo($fecha);
        
        
        if ($periodo == null) {
            
            /** @var Carbon $startDateRef */
            $startDateRef = Carbon::createFromDate($fecha->format('Y'), $fecha->format('m'), $fecha->format('d'));
            
            /** @var Carbon $startEndRef */
            $endDateRef = Carbon::createFromDate($fecha->format('Y'), $fecha->format('m'), $fecha->format('d'));
            
            $dia = (int)$fecha->format('d');
            
            if ($dia <= 15) {
                // Segunda parte de un periodo. La fecha de comienzo es el 16 del mes anterior
                
                $startDateRef->subMonth(1);
                $startDate = Carbon::createFromDate($startDateRef->format('Y'), $startDateRef->format('m'), 16);
                // La segunda fecha, es la de este mes, y este anio
                $endDate = Carbon::createFromDate($fecha->format('Y'), $fecha->format('m'), 15);
            } else {
                // Primer parte de un periodo. La fecha de inicio es 16 de este mes
                // la fecha de cierre es 15 del mes que viene
                $endDateRef->addMonth(1);
                
                $startDate = Carbon::createFromDate($fecha->format('Y'), $fecha->format('m'), 16);
                $endDate   = Carbon::createFromDate($endDateRef->format('Y'), $endDateRef->format('m'), 15);
                
                
            }
            
            
            $periodo = Periodo::create([
                'fecha_comienzo' => $startDate->format('Y-m-d'),
                'fecha_fin'      => $endDate->format('Y-m-d'),
                'cant_dias'      => abs($endDateRef->diffInDays($startDateRef)),
            ]);
            
            PeriodoRepository::activarPeriodoEnBasesYTurnos($periodo);
        }
        
        return $periodo;
    }
}