<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Handlers\Error;
use Cat\Helpers\Validation;
use Cat\Http\Requests\LaboralesRequest;
use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Agentes\Services\Registro\Store\Laborales as Store;
use Cat\Modules\Agentes\Services\Registro\Update\Laborales as Update;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Response;

class LaboralesController extends AppBaseController
{
    /** @var  AgenteRepository */
    private $agenteRepository;
    
    
    public function __construct(AgenteRepository $agenteRepo)
    {
        $this->agenteRepository = $agenteRepo;
        $this->middleware('auth');
        
    }
    
    
    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($id)
    {
        $this->authorize('create', $this);
        
        $agente = Agente::find($id);
        
        if (empty($agente)) {
            Flash::error('Agente no encontrado');
            
            return redirect(route('agentesCreatePersonales'));
        }
        
        return view('Agentes::registro.create')
            ->with('tab', 'laborales')
            ->with('agente', $agente);
    }
    
    
    /**
     * @param LaboralesRequest $request
     * @return $this
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(LaboralesRequest $request)
    {
        $this->authorize('store', $this);
        
        $input = $request->all();
        
        $this->validate($request, Validation::getContratoRules($request));
        
        
        try {
            $agente  = Agente::find($input['agente']);
            $service = new Store($agente, $input);
            
            $service->execute();
            
            return redirect(route('agentesCreateOperativos', ['id' => $agente->id]));
        } catch (\Exception $e) {
            
            $validator = Validator::make(['operacion' => null], ['operation |required']);
            $validator->after(function ($validator) use ($e) {
                $validator->errors()->add('operacion', Error::getRespuestaAdecuada($e, 'agente'));
            });
            
            return redirect(route('agentesCreateLaborales', ['id' => $agente->id]))
                ->withErrors($validator)
                ->withInput();
        }
        
        
    }
    
    
    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
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
            
            return redirect(route('agentesIndex', ['base' => 1]));
        }
        
        return view('Agentes::registro.edit')
            ->with('agente', $agente)
            ->with('contrato', $agente->contrato()->first())
            ->with('tab', 'laborales');
    }
    
    /**
     * @param LaboralesRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(LaboralesRequest $request)
    {
        $this->authorize('update', $this);
        
        
        $input = $request->all();
        
        $agente = Agente::find($input['agente']);
        
        if (empty($agente)) {
            Flash::error('Agente no encontrado');
            
            return redirect(route('agentesIndex', ['base', 1]));
        }
        
        try {
            
            $service = new Update($agente, $input);
            $service->execute();
            Flash::success('Datos laborales actualizados correctamente.');
            
            return redirect(route('agentesEditOperativos', ['id' => $agente->id]));
            
            
        } catch (\Exception $e) {
            
            Flash::error('No se pudo actualizar los datos laborales.');
            
            return redirect(route('agentesEditLaborales', ['id' => $agente->id]));
            
        }
    }
    
    /**
     * Remove the specified Presentismo from storage.
     *
     * @param  int $id
     *
     * @return Response
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
