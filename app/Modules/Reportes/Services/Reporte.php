<?php

namespace Cat\Modules\Reportes\Services;

use Cat\Modules\Reportes\Services\Formatters\RowDataFormatter;
use Cat\Modules\Service;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class Reporte extends Service
{
    
    /** @var  Collection */
    protected $collection;
    protected $rowFormatter;
    
    /**
     * Reporte constructor.
     * @param Collection $collection
     * @param string $whoDecideWhatToShow Class name of formmater Must be RowDataFormatter
     */
    public function __construct(Collection $collection,  $whoDecideWhatToShow)
    {
        $this->collection   = $collection;
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
                
                /** @var  LaravelExcelWorksheet $sheet */
                $data = [];
                foreach ($this->collection as $model) {
                    $data [] = $this->rowFormatter->format($model);
                }
                $sheet->fromArray($data);
                
            });
        })->export('xls');
        
    }
    
    
}