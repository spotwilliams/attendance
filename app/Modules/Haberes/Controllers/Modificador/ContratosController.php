<?php

namespace Cat\Modules\Haberes\Controllers\Modificador;

use Cat\Http\Controllers\AppBaseController;
use Cat\Models\Agente;
use Cat\Models\Gerencia;
use Cat\Models\Operativo;
use Cat\Modules\Haberes\Services\Modificador\Contratos;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Laracasts\Flash\Flash;

class ContratosController extends AppBaseController
{
    
    public function __construct()
    {
        $this->middleware('auth');
        
    }
    
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', $this);
        
        return view('Haberes::modificador.index');
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function disclosure(Request $request)
    {
        $this->authorize('update', $this);
        
        $this->validate($request,
            [
                'gerencias'      => 'required',
                'fecha_contrato' => 'required|date|before:today',
                'monto'          => 'required',
            ]);
        
        /** @var Collection $gerencias */
        $gerencias = Gerencia::whereIn('id', $request->input('gerencias'))
            ->get();
        
        /** @var Collection $operativos */
        $operativos = Operativo::whereIn('id_gerencia', $gerencias->pluck('id'))
            ->get();
        
        /** @var Collection $agentes */
        $agentes = Agente::whereIn('id', $operativos->pluck('id_agente'))
            ->with(['operativo' => function($with) {
                $with
                    ->with('base')
                    ->with('turno')
                    ->with('gerencia')
                ;
            }])
            ->get();
        
        return view('Haberes::modificador.disclosure')
            ->with('gerencias', $gerencias)
            ->with('agentes', $agentes)
            ->with('monto', $request->input('monto'))
            ->with('fecha', new \DateTime($request->input('fecha_contrato')));
        
    }
    
    
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request)
    {
        $this->authorize('update', $this);
        
        try {
            $service = new Contratos(
                $request->input('gerencias'),
                new \DateTime($request->input('fecha_contrato')),
                $request->input('monto')
            );
            
            $service->execute();
        } catch (\Exception $e) {
            Flash::error('No se pudieron actualizar los datos de los contratos');
        }
        
        Flash::success('Se actualizaron los montos y las fechas correctamente');
        
        return view('Haberes::modificador.index');
    }
}
