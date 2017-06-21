<?php
/**
 * Created by PhpStorm.
 * User: worker
 * Date: 5/5/17
 * Time: 11:19
 */

namespace Cat\Modules\Haberes\Services\Reporte;

use Cat\Modules\Service;
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
                $data = [];
                foreach ($this->haberes as $haber) {
                    $data [] = [
                        'Nombre'           => $haber->agente->nombre,
                        'Apellido'         => $haber->agente->apellido,
                        'CUIT'             => $haber->agente->cuit,
                        'Monto a Facturar' => $haber->monto_facturado,
                    ];
                }
                $sheet->fromArray($data);
                
            });
        })->export('xls');
        
    }
    
    
}