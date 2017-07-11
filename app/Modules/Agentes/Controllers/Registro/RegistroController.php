<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Models\Agente;
use Cat\Models\Operativo;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Agentes\Services\Registro\Destroy\Laborales;
use Cat\Modules\Agentes\Services\Registro\Destroy\Operativos;
use Cat\Modules\Agentes\Services\Registro\Destroy\Personales;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;

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
        $agentes = $this->agenteRepository->getAgentesByBase($base);
        
        return view('Agentes::registro.index')
            ->with('baseActual', $base)
            ->with('agentes', $agentes);
    }
    
    
    public function show($id)
    {
        try {
            // Se verifica que el agente exista
            $agente = Agente::findOrFail($id);
            // Se verifica que se haya terminado la carga de sus datos
            $operativo = Operativo::findOrFail($agente->operativo->id);
            
            return view('Agentes::registro.show')
                ->with('agente', $agente);
        } catch (\Exception $e) {
            Flash::warning('Agente inexistente o con datos incompletos. Si el agente existe, intente completando todos sus datos.');
            
            return redirect(route('agentesSearchIndex'));
            
        }
        
    }
    
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
