<?php

namespace Cat\Modules\Reportes\Controllers\Presentismos;

use Cat\Helpers\Calculation;
use Cat\Modules\Reportes\Services\Formatters\Presentismo;
use Cat\Modules\Reportes\Services\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;

class Exportar extends General
{
    
    /**
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return Response
     */
    public function export(Request $request)
    {
//        $this->authorize('export', $this);
        
        $this->setupParams($request)
            ->setupQuery();
        
        $formatter = new Presentismo($this->desde, $this->hasta);
        $service   = new Reporte($this->query, $formatter);
        try {
            $service->execute();
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            
            return redirect(route('reportesPresentismoGeneralIndex'));
        }
    }
    
    protected function setupQuery()
    {
        parent::setupQuery();
        $this->query
            ->with([
                'presentismos' => function ($query) {
                    if (!$this->tiposPresentismos->isEmpty()) {
                        $query->whereIn('id_tipo_presentismo', $this->tiposPresentismos->toArray());
                    }
                    $query->whereDate('fecha', '>=', $this->desde)
                        ->whereDate('fecha', '<=', $this->hasta)
                        ->orderBy('fecha', 'ASC')
                        ->with([
                            'tipoPresentismo' => function ($tipo) {
                                $tipo->select([
                                    'id',
                                    'codigo',
                                    'descripcion',
                                ]);
                            },
                        ])
                        ->with('comentarios.user');
                },
            ])
            ->with([
                'operativo.base' => function ($with) {
                    $with->select(['id', 'nombre as nombre_base']);
                },
            ])
            ->with([
                'operativo.turno' => function ($turno) {
                    $turno->select(['id', 'codigo as turno']);
                },
            ])
            ->with([
                'contrato.tipoContrato' => function ($tipo) {
                    $tipo->select(['id', 'descripcion as tipo_contrato']);
                },
            ]);
    }
    
}
