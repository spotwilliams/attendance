<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Models\Agente;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Agentes\Services\Registro\Destroy\Laborales;
use Cat\Modules\Agentes\Services\Registro\Destroy\Operativos;
use Cat\Modules\Agentes\Services\Registro\Destroy\Personales;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class RegistroController extends AppBaseController
{
    /** @var  AgenteRepository */
    private $agenteRepository;
    
    
    public function __construct(AgenteRepository $agenteRepo)
    {
        $this->agenteRepository = $agenteRepo;
        $this->middleware('auth');
        
    }
    
    /**
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request, $base)
    {
        $this->authorize('index', $this);
        $agentes = $this->agenteRepository->getAgentesByBase($base);
        
        return view('Agentes::registro.index')
            ->with('baseActual', $base)
            ->with('agentes', $agentes);
    }
    
    
    public function show($id)
    {
        $this->authorize('show', $this);
    
        try {
            // Se verifica que el agente exista
            $agente = Agente::findOrFail($id);
            
            return view('Agentes::registro.show')
                ->with('agente', $agente);
        } catch (\Exception $e) {
            Flash::warning('Agente inexistente');
            
            return redirect(route('agentesSearchIndex'));
            
        }
        
    }
    
    
    /**
     * @obsolete No se permiten eliminaciones
     */
    public function delete($id)
    {
        try {
            $agente = Agente::findOrFail($id);
            
            return view('Agentes::registro.delete')
                ->with('agente', $agente);
        } catch (ModelNotFoundException $e) {
            session()->flash('flash_notification.message',
                'Se inten&oacute; acceder a informaci&oacute;n inexistente o no permitida');
            session()->flash('flash_notification.level', 'warning');
            
            return view('Agentes::registro.index', ['base' => 1])->with('baseActual', 1);
            
        }
        
    }
    
    /**
     * @obsolete No se permiten eliminaciones
     */
    public function destroy(Request $request)
    {
        try {
            $agente   = Agente::findOrFail($request->input('agente'));
            $services = [
                Operativos::class,
                Laborales::class,
                Personales::class,
            ];
            foreach ($services as $service) {
                (new $service($agente))->execute();
            }
            Flash::success('Se ha eliminado el agente seleccionado.');
            
        } catch (ModelNotFoundException $e) {
            Flash::warning('Se inten&oacute; acceder a informaci&oacute;n inexistente o no permitida');
            
        } catch (\Exception $e) {
            Flash::warning('Sucedi&oacute; un error al intentar borrar');
            
        }
        
        return redirect(route('agentesIndex', ['base' => 1]));
        
        
    }
}
