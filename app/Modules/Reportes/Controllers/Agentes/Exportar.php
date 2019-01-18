<?php

namespace Cat\Modules\Reportes\Controllers\Agentes;


use Cat\Modules\Reportes\Services\Formatters\Agente;
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
        $this->authorize('export', $this);
        $this->setupParams($request)
            ->setupQuery();
        
        $formatter = new Agente();
        $service = new Reporte($this->query, $formatter);
        try {
            $service->execute();
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            return redirect(route('reportesAgentesGeneralIndex'));
    
        }
    }
    
    protected function setupQuery()
    {
        parent::setupQuery();
        $this->query
            ->with('domicilios')
            ->with('estudio')
            ->with([
                'operativo.base' => function ($with) {
                    $with->select(['id', 'nombre']);
                },
            ])
            ->with([
                'operativo.turno' => function ($turno) {
                    $turno->select(['id', 'descripcion', 'codigo']);
                },
            ])
            ->with([
                'operativo.cargo' => function ($cargo) {
                    $cargo->select(['id', 'nombre']);
                },
            ])
            ->with([
                'operativo.funcion' => function ($funcion) {
                    $funcion->select(['id', 'nombre']);
                },
            ])
            ->with([
                'operativo.area' => function ($area) {
                    $area->select(['id', 'nombre']);
                },
            ])
            ->with([
                'operativo.gerencia' => function ($gerencia) {
                    $gerencia->select(['id', 'nombre']);
                },
            ])
            ->with([
                'contrato.tipoContrato' => function ($tipo) {
                    $tipo->select(['id', 'descripcion', 'codigo']);
                },
            ])
            ->with([
                'contrato.estadoContrato' => function ($estado) {
                    $estado->select(['id', 'descripcion']);
                },
            ]);
    }
}
