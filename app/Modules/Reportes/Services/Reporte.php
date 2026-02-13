<?php

namespace Cat\Modules\Reportes\Services;

use Cat\Modules\Reportes\Exports\ReporteExport;
use Cat\Modules\Reportes\Services\Formatters\RowDataFormatter;
use Cat\Modules\Service;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

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

    public function execute()
    {
        // 5 hs threshold
        ini_set('max_execution_time', 18000);
        ini_set('memory_limit', '-1');

        $page = 1;
        $data = [];
        do {
            $models = $this->eloquent->simplePaginate(150, ['*'], 'page', $page);
            $page++;
            foreach ($models->items() as $model) {
                $data[] = $this->rowFormatter->format($model);
            }
        } while ($models->hasMorePages());

        $collection = collect($data);
        $headings = $collection->first() ? array_keys($collection->first()) : [];

        $export = new ReporteExport($collection, $headings);
        return Excel::download($export, 'Reporte.xlsx');
    }
}
