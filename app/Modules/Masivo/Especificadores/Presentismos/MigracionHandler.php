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
                        } catch (\Exception $e) {
                            
                            $this->listaErrores[] = [
                                'agente'           => $row[0],
                                'cuit'             => $row[1],
                                'fecha'            => ($fechas[$j])->format('d/m/Y'),
                                'tipo_presentismo' => $row[$j],
                                'mensaje'          => $e->getMessage(),
                            ];
                        }
                        
                    }
                }
            } catch (\Exception $e) {
                $this->listaErrores[] = [
                    'agente'           => $row[0],
                    'cuit'             => $row[1],
                    'fecha'            => 'N/A',
                    'tipo_presentismo' => 'N/A',
                    'mensaje'          => $e->getMessage(),
                ];
            }
            
            
        }
        
        $fileErrores->sheet('Errores', function ($sheet) {
            
            $sheet->fromArray($this->listaErrores);
            
        })->store('xls', $this->location, true);
        
        Flash::warning('Se finaliz&oacute; el proceso de importaci&oacute;n');
        
    }
    
    private function getAgente($cuit)
    {
        return Agente::where('cuit', '=', str_replace('-', '', $cuit))
            ->with('contrato.tipoContrato')
            ->firstOrFail();
    }

//    private function getDatesWithPresentismos(CellCollection $row, Agente $agente, $fechas)
//    {
//        $data = $row->all();
//        unset($data['nombre']);
//        unset($data['apellido']);
//        unset($data['cuit']);
//        $return = [];
//        foreach ($data as $fecha => $codigoPresentismo) {
//
//            try {
//                $tipoPresentismo = TipoPresentismo::where('codigo', '=', $codigoPresentismo)
//                    ->where('aplica', '=', $agente->contrato->TipoContrato->codigo)
//                    ->firstOrFail();
//
//                $return [] = [
//                    'fecha'            => new \DateTime($fechas[$fecha]),
//                    'tipo_presentismo' => $tipoPresentismo,
//                ];
//            } catch (ModelNotFoundException $noEncontratoPrimerIntento) {
//                try {
//
//                    $tipoPresentismo = TipoPresentismo::where('codigo', '=', $codigoPresentismo)
//                        ->where('aplica', '=', 'TODOS')
//                        ->firstOrFail();
//
//                    $return [] = [
//                        'fecha'            => new \DateTime($fechas[$fecha]),
//                        'tipo_presentismo' => $tipoPresentismo,
//                    ];
//                } catch (ModelNotFoundException $noEncontratoSegundoIntento) {
//
//                    $this->listaErrores[] = [
//                        'cuit'             => $row->cuit,
//                        'fecha'            => $fechas[$fecha],
//                        'tipo_presentismo' => $codigoPresentismo,
//                        'mensaje'          => 'El tipo de presentismo no se corresponde con el tipo de contrato. Intente manualmente desde la interfaz',
//                    ];
//                }
//            }
//
//        }
//
//        return $return;
//    }
    
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