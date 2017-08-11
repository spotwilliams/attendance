<?php

namespace Cat\Modules\Reportes\Services;

use Cat\Modules\Reportes\Services\Formatters\Agente;
use Cat\Modules\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class Reporte extends Service
{
    
    /** @var  Builder */
    protected $eloquent;
    protected $rowFormatter;
    
    /**
     * Reporte constructor.
     * @param Builder $eloquent
     * @param string $whoDecideWhatToShow Class name of formmater Must be RowDataFormatter
     */
    public function __construct(Builder $eloquent, $whoDecideWhatToShow)
    {
        $this->eloquent     = $eloquent;
        $this->rowFormatter = new $whoDecideWhatToShow();
    }
    
    
    /**
     * @return bool
     */
    public function execute()
    {
        Excel::create('Reporte', function ($writer) {
            /** @var LaravelExcelWriter $writer */
            $writer->sheet('Reporte', function ($sheet) {

//                /** @var  LaravelExcelWorksheet $sheet */
//                $data = [];
//                foreach ($this->eloquent as $model) {
//                    $data [] = $this->rowFormatter->format($model);
//                }
//                $sheet->fromArray($data);
                /** @var Paginator $models */
                $page = 1;
                do {
                    $models = $this->eloquent->simplePaginate(150, ['*'], 'page', $page);
                    
                    $page++;
                    $data = [];
                    foreach ($models->items() as $model) {
                        $data [] = $this->rowFormatter->format($model);
                    }
                    $sheet->fromArray($data);
                    
//                    die('hola');
                } while ($models->hasMorePages());
//                $this->eloquent->chunk(500, function ($models) use ($sheet) {
//                    /** @var Agente $model */
//                    $data = [];
//                    dd($models);
//                    foreach ($models as $model) {
//                        $data [] = $this->rowFormatter->format($model);
//                    }
//                    $sheet->fromArray($data);
//
//                });
                
            });
        })->export('xls');
        
    }
    
    
}