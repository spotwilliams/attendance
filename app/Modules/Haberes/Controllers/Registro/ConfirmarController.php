<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Cat\Modules\Haberes\Services\Helpers\Facilitador;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class ConfirmarController extends AppBaseController
{
    /** @var  PresentismoRepository */
    private $presentismoRepository;
    
    public function __construct(PresentismoRepository $presentismoRepo)
    {
        $this->presentismoRepository = $presentismoRepo;
        $this->middleware('auth');
        
    }
    
    public function disclaimer(Request $request)
    {
        $this->authorize('disclaimer', $this);
        
        try {
            $input = $request->all();
            
            /** @var Periodo $periodo */
            $periodo = Periodo::findOrFail($input['periodo']);
            $base    = Base::findOrFail($input['base']);
            $turno   = Turno::findOrFail($input['turno']);
            
            if ($periodo->fechaComprendida(new \DateTime('now'))) {
                Flash::error('No se puede cerrrar el periodo actual, debe seleccionar un peri&oacute;do que no incluya la fecha actual');
                
                return redirect(route('haberesListaAgentes', [
                    'base'    => $base,
                    'periodo' => $periodo,
                    'turno'   => $turno,
                ]));
            }
            
            return view('Haberes::calculo.disclaimer')
                ->with('base', $base)
                ->with('periodo', $periodo)
                ->with('turno', $turno);
            
            
        } catch (\Exception $exception) {
            Flash::error('Hubo un error durante la ejecución. Intente nuevamente');
            
            return redirect()->back();
            
        }
        
    }
    
    public function batch(Request $request)
    {
        $this->authorize('batch', $this);
    
        try {
            $input   = $request->all();
            $periodo = Periodo::findOrFail($input['periodo']);
            $base    = Base::find($input['base']);
            $turno   = Turno::findOrFail($input['turno']);
            
            Facilitador::batch($base, $periodo, $turno);
            Flash::success('Periodo cerrado con &eacute;xito');
            
            return view('Haberes::calculo.end')
                ->with('periodo', $periodo)
                ->with('base', $base)
                ->with('turno', $turno);
            
        } catch (ModelNotFoundException $exception) {
            Flash::error('Hubo un error durante la ejecución. Intente nuevamente');
            
            return redirect()->back();
            
        }
    }
    
}
