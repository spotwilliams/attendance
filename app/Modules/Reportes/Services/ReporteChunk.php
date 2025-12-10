<?php

namespace Cat\Modules\Reportes\Services;

use Cat\Modules\Reportes\Services\Formatters\Agente;
use Cat\Modules\Reportes\Services\Formatters\RowDataFormatter;
use Cat\Modules\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Pagination\Paginator;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class ReporteChunk extends Service
{
    
    /** @var  Builder */
    protected $eloquent;
    /** @var  RowDataFormatter */
    protected $rowFormatter;
    protected $includeResume;
    private   $row;
    
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
        $this->row           = 2;
    }
    
    
    /**
     * @return bool
     */
    public function execute()
    {
        // 5 hs threshold
        ini_set('max_execution_time', 18000);
        ini_set('memory_limit', '-1');
        
        
        return Excel::create('Reporte', function ($writer): void {
            /** @var LaravelExcelWriter $writer */
            $writer->sheet('Reporte', function ($sheet): void {
                
                /** @var LaravelExcelWorksheet $sheet */
                /** @var Paginator $models */
                $page = 1;
                $data = [];
                do {
                    $models = $this->eloquent->simplePaginate(150, ['*'], 'page', $page);
                    
                    $page++;
                    foreach ($models->items() as $model) {
                        $sheet->appendRow($this->row++, $this->rowFormatter->format($model));
                    }

                } while ($models->hasMorePages());
            });
            
        })->download('xlsx');
        
    }
    
    
}