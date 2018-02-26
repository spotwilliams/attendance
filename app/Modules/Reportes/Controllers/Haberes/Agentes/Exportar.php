<?php

namespace Cat\Modules\Reportes\Controllers\Haberes\Agentes;

use Cat\Modules\Reportes\Services\Formatters\HaberesPorAgente;
use Cat\Modules\Reportes\Services\Reporte;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class Exportar extends General
{
    
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function export(Request $request)
    {
        $this->authorize('export', $this);
        $this->setupParams($request)
            ->setupQuery();
        $formatter = new HaberesPorAgente();
        $service   = new Reporte($this->query, $formatter);
        try {
            $service->execute();
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            
            return view('Reportes::haberes.index-general');
        }
    }
    
}
