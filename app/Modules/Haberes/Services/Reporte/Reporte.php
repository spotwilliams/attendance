<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 11:19
 */

namespace Cat\Modules\Haberes\Services\Reporte;

use Cat\Modules\Service;
use Cat\Repositories\TipoPresentismosRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class Reporte extends Service
{
    
    /** @var  Collection */
    protected $haberes;
    
    public function __construct(Collection $haberesWithAgentes)
    {
        $this->haberes = $haberesWithAgentes;
    }
    
    
    /**
     * @return bool
     */
    public function execute()
    {
        Excel::create('Reporte', function ($writer) {
            /** @var LaravelExcelWriter $writer */
            $writer->sheet('Haberes', function ($sheet) {
                
                /** @var  LaravelExcelWorksheet $sheet */
                $data  = [];
                $index = 0;
                foreach ($this->haberes as $haber) {
                    $data [$index] = [
//                        'id'                             => $haber->agente->id,
                        'Nombre'                         => $haber->agente->nombre,
                        'Apellido'                       => $haber->agente->apellido,
                        'CUIT'                           => $haber->agente->cuit,
                        'Monto a Facturar'               => $haber->monto_facturado,
                        'Cantidad faltas Injustificadas' => (string)TipoPresentismosRepository::getCantFaltasInjustificadas($haber->agente,
                            $haber->periodo),
                    ];
                    $detalleFaltas = TipoPresentismosRepository::getFaltasInjustificadas($haber->agente,
                        $haber->periodo, false);
                    
                    foreach ($detalleFaltas as $falta) {
                        $data[$index][$falta->fecha . ' (fecha)']  = $falta->fecha;
                        $data[$index][$falta->fecha . ' (codigo)'] = $falta->tipoPresentismo->codigo;
                    }
                    $index++;
                }
                $sheet->fromArray($data);
                
            });
        })->export('xls');
        
    }
    
    
}