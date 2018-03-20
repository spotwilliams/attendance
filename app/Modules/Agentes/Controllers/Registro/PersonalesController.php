<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Helpers\Validation;
use Cat\Models\Agente;
use Cat\Modules\Agentes\Exceptions\Registro\EntidadDuplicada;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Agentes\Services\Registro\Store\Personales as Store;
use Cat\Modules\Agentes\Services\Registro\Update\Personales as Update;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Gate;
use Laracasts\Flash\Flash;

class PersonalesController extends AppBaseController
{
    /** @var  AgenteRepository */
    private $agenteRepository;
    
    
    public function __construct(AgenteRepository $agenteRepo)
    {
        $this->agenteRepository = $agenteRepo;
        $this->middleware('auth');
        
    }
    
    
    /**
     * @return $this
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', $this);
        
        return view('Agentes::registro.create')
            ->with('tab', 'personales');
    }
    
    
    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse|Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize('store', $this);
        
        $input = $request->all();
        $rules = array_merge(Agente::$rules, Validation::getDomicilioRules($request));
        
        $this->validate($request, $rules);
        $agente = new Agente($input);
        
        try {
            $service = new Store($agente, $input['domicilio'], $input['estudio'], $request->file('avatar'));
            $service->execute();
            
            return redirect(route('agentesCreateLaborales', ['id' => $agente->id]));
        } catch (EntidadDuplicada $e) {
            Flash::error($e->getMessage());
            
            return redirect(route('agentesCreatePersonales'))
                ->withInput();
            
        } catch (\Exception $e) {
            Flash::error('No se pudo guadar los datos personales.');
            
            return redirect(route('agentesCreatePersonales'))
                ->withInput();
            
        }
        
        
    }
    
    
    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $this->authorize('edit', $this);
        
        try {
            $agente = Agente::with('operativo.turno')
                ->with('operativo.base')
                ->findOrFail($id);
            if (($agente->operativo) and ($agente->operativo->base) and ($agente->operativo->turno)) {
                
                Gate::allows('work-bases', [[$agente->operativo->base->id]]);
                Gate::allows('work-turnos', [[$agente->operativo->turno->id]]);
            }
        } catch (ModelNotFoundException $e) {
            Flash::error('Agente no encontrado');
            
            return redirect(route('agentesCreatePersonales'));
        }
        
        
        return view('Agentes::registro.edit')
            ->with('agente', $agente)
            ->with('tab', 'personales');
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request)
    {
        $this->authorize('update', $this);
        
        $rules         = array_merge(Agente::$rules, Validation::getDomicilioRules($request));
        $rules['cuit'] = 'required|cuit';
        
        $this->validate($request, $rules);
        $input  = $request->all();
        $agente = Agente::find($input['id']);
        
        if (empty($agente)) {
            Flash::error('Agente no encontrado');
            
            return redirect(route('agentesIndex', ['base', 1]));
        }
        
        try {
            
            $service = new Update($agente, $input, $request->file('avatar'));
            $service->execute();
            Flash::success('Datos personales actualizados correctamente.');
            
            return redirect(route('agentesEditLaborales', ['id' => $agente->id]));
            
            
        } catch (\Exception $e) {
            Flash::error('No se pudo actualizar los datos personales.');
            
            return redirect(route('agentesEditPersonales', ['id' => $agente->id]));
            
        }
        
        
    }
    
    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $this->authorize('destroy', $this);
        
        $presentismo = $this->agenteRepository->findWithoutFail($id);
        
        if (empty($presentismo)) {
            Flash::error('Presentismo not found');
            
            return redirect(route('Presentismo::registro.index'));
        }
        
        $this->agenteRepository->delete($id);
        
        Flash::success('Presentismo deleted successfully.');
        
        return redirect(route('Presentismo::registro.index'));
    }
}
