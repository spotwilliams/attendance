<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Periodo;
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
    
    
    public function single(Request $request)
    {
        
        try {
            $input = $request->all();
            
            $agente  = Agente::findOrFail($input['agente']);
            $periodo = Periodo::findOrFail($input['periodo']);
            $base    = Base::find($input['base']);
            
            Facilitador::single($agente, $periodo);
            
            Flash::success('Monto a pagar confirmado con &eacute;xito');
        } catch (ModelNotFoundException $exception) {
            Flash::error('No se pudieron encontrar los datos necesarios. Intente nuevamente');
        } catch (\Exception $exception) {
            Flash::error('Hubo un error durante la ejecución. Intente nuevamente');
        }
        
        return redirect(route('haberesListaAgentes',
            ['base' => $base->id, 'periodo' => $periodo->id, 'page' => $input['page']]));
        
    }
    
    public function batch(Request $request)
    {
        try {
            $input = $request->all();
            
            $agentes = $input['agentes'];
            $periodo = Periodo::findOrFail($input['periodo']);
            $base    = Base::find($input['base']);
            
            Facilitador::bacth($agentes, $periodo);
            
            Flash::success('Monto a pagar confirmado con &eacute;xito');
        } catch (ModelNotFoundException $exception) {
            Flash::error('No se pudieron encontrar los datos necesarios. Intente nuevamente');
        } catch (\Exception $exception) {
            Flash::error('Hubo un error durante la ejecución. Intente nuevamente');
        }
        
        return redirect(route('haberesListaAgentes',
            ['base' => $base->id, 'periodo' => $periodo->id, 'page' => $input['page']]));
        
    }
    
}
