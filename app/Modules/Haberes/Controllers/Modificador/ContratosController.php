<?php

namespace Cat\Modules\Haberes\Controllers\Modificador;

use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Haberes\Services\Modificador\Contratos;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ContratosController extends AppBaseController
{
    
    public function __construct()
    {
        $this->middleware('auth');
        
    }
    
    
    public function index()
    {
        $this->authorize('index', $this);
        return view('Haberes::modificador.index');
    }
    
    public function update(Request $request)
    {
        $this->authorize('update', $this);
        
        $this->validate($request,
            ['gerencias' => 'required', 'fecha_contrato' => 'required|date|before:today', 'monto' => 'required']);
        
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
