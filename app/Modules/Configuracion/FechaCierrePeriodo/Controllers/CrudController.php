<?php

namespace Cat\Modules\Configuracion\FechaCierrePeriodo\Controllers;

use Cat\Models\Param;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class CrudController extends AppBaseController
{
    
    
    /**
     * @return $this
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', $this);
        
        return view('Configuracion::fecha_cierre_periodo.index')
            ->with('fecha', Param::fechaCierre());
    }
    
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request)
    {
        $this->authorize('update', $this);
        
        $fecha = Param::fechaCierre();
        
        $fecha->valor = $request->input('dia');
        
        $fecha->save();
        
        Flash::success('D&iacute;a de cierre actualizado correctamente.');
        
        return redirect(route('configuracion.fecha.cierre.index'));
    }
    
    
}
