<?php

namespace Cat\Modules\Reportes\Services;

use Cat\Modules\Reportes\Services\Formatters\RowDataFormatter;
use Cat\Modules\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;

class ReporteAsStream extends Service
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
     * @return mixed
     */
    public function execute()
    {
        // 5 hs threshold
        ini_set('max_execution_time', 18000);
        ini_set('memory_limit', '-1');
        
        
        return Response::stream(function (): void {
            $page       = 1;
            $allRecords = 0;
            echo  $this->rowFormatter->getEncabezado() . "\r\n";
            try {
                
                do {
                    /** @var LengthAwarePaginator $models */
                    $models = $this->eloquent->simplePaginate(150, ['*'], 'page', $page);
                    
                    $page++;
                    foreach ($models->items() as $model) {
                        $allRecords++;
                        $field  = $this->rowFormatter->format($model);
                        
                        echo $field . "\r\n";
                        
                    }
                    flush();
                } while ($models->isEmpty() ? false : true);
            } catch (\Exception $e) {
                echo ($e->getMessage()) . $e->getFile() . $e->getLine();
            }
            
        }, 200, [
//             Stream headers
'Content-type'        => 'text/csv',
'Content-disposition' => 'attachment;filename=ReportePresentismo.csv',
'Pragma'              => 'no-cache',
'Cache-Control'       => 'no-cache, no-store, must-revalidate',
'Expires'             => '0',
        ]);
        
    }
    
    
}