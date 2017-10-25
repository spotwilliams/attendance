<?php

namespace Cat\Modules\Reportes\Services;

use Cat\Modules\Reportes\Services\Formatters\RowDataFormatter;
use Cat\Modules\Service;
use Illuminate\Database\Eloquent\Builder;
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
     * @return bool
     */
    public function execute()
    {
        // 5 hs threshold
        ini_set('max_execution_time', 18000);
        ini_set('memory_limit', '-1');
        
        
        return Response::stream(function () {
            
            $page = 1;
            do {
                $models = $this->eloquent->simplePaginate(150, ['*'], 'page', $page);
                
                $page++;
                foreach ($models->items() as $model) {
                    $data = $this->rowFormatter->format($model);
                    echo (implode(',', $data)) . PHP_EOL;
                }
                flush();
            } while ($models->hasMorePages());
            
        }, 200, [
            // Stream headers
            'Content-type'        => 'text/csv',
            'Content-disposition' => 'attachment;filename=ReportePresentismo.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Expires'             => '0',
        ]);
        
    }
    
    
}