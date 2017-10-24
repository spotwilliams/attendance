<?php

namespace Cat\Modules\Reportes\Services;

use Cat\Modules\Reportes\Services\Formatters\Agente;
use Cat\Modules\Reportes\Services\Formatters\RowDataFormatter;
use Cat\Modules\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class Reporte extends Service
{
    
    /** @var  Builder */
    protected $eloquent;
    /** @var  RowDataFormatter */
    protected $rowFormatter;
    protected $includeResume;
    
    /**
     * Reporte constructor.
     * @param Builder $eloquent
     * @param RowDataFormatter $whoDecideWhatToShow
     * @param bool $includeResume
     */
    public function __construct(Builder $eloquent, RowDataFormatter $whoDecideWhatToShow, $includeResume = false)
    {
        $this->eloquent      = $eloquent;
        $this->rowFormatter  = $whoDecideWhatToShow;
        $this->includeResume = $includeResume;
    }
    
    
    /**
     * @return bool
     */
    public function execute()
    {
        // 5 hs threshold
        ini_set('max_execution_time', 18000);
        ini_set('memory_limit', '-1');
    
    
        Excel::create('Reporte', function ($writer) {
            /** @var LaravelExcelWriter $writer */
            $writer->sheet('Reporte', function ($sheet) {
                
                /** @var Paginator $models */
                $page = 1;
                $data = [];
                do {
                    $models = $this->eloquent->simplePaginate(150, ['*'], 'page', $page);
                    
                    $page++;
                    foreach ($models->items() as $model) {
                        $data [] = $this->rowFormatter->format($model);
                    }
                    
                } while ($models->hasMorePages());
                $sheet->fromArray($data);
            });
            
            if ($this->includeResume) {
                $writer->sheet('Resumen', function ($sheet) {
                    $models  = $this->eloquent->get();
                    $resumen = [];
                    foreach ($models as $model) {
                        
                        $resumen[$model->id]
                        ['presentismos']
                                                      = $model->presentismos->groupBy(
                            function ($presentismo, $key) {
                                if ($presentismo->injustificado == true) {
                                    $name = '_injustificados';
                                } else {
                                    $name = '_justificados';
                                    
                                }
                                
                                return $presentismo->tipoPresentismo->codigo . $name;
                            });
                        $resumen[$model->id]['owner'] = $model;
                        
                    }
                    $data = [];
                    foreach ($resumen as $item) {
                        $agente       = $item['owner'];
                        $temp         = [
                            'nombre' => $agente->nombre . ', ' . $agente->apellido,
                            'cuit'   => $agente->cuit,
                            'base'   => $agente->operativo->base->nombre,
                            'turno'  => $agente->operativo->turno->codigo,
                        ];
                        $presentismos = $item['presentismos']->toArray();
                        
                        foreach ($presentismos as $codigo => $dias) {
                            $temp[$codigo] = count($dias);
                        }
                        $data [] = $temp;
                    }
                    $sheet->fromArray($data);
                });
                
            }
            
        })->export('xls');
        
    }
    
    
}