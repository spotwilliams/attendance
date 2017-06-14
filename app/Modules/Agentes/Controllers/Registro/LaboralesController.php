<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Handlers\Error;
use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Agentes\Services\Registro\Store\Laborales as Store;
use Cat\Modules\Agentes\Services\Registro\Update\Laborales as Update;
use Illuminate\Http\Request;
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
     * Show the form for creating a new Presentismo.
     *
     * @return Response
     */
    public function create($id)
    {
        $agente = Agente::find($id);
        
        if (empty($agente)) {
            Flash::error('Agente no encontrado');
            
            return redirect(route('agentesCreatePersonales'));
        }
        
        return view('Agentes::registro.create')
            ->with('tab', 'laborales')
            ->with('agente', $id);
    }
    
    
    /**
     * Store a newly created Presentismo in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        $this->validate($request, Contrato::$rules);
        
        
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
     * Show the form for editing the specified Presentismo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Agente $agente */
        $agente = Agente::find($id);
        
        if (empty($agente)) {
            Flash::error('Agente no encontrado');
            
            return redirect(route('agentesIndex', ['base' => 1]));
        }
        
        return view('Agentes::registro.edit')
            ->with('agente', $agente->id)
            ->with('contrato', $agente->contrato()->first())
            ->with('tab', 'laborales');
    }
    
    /**
     * Update the specified Presentismo in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validate($request, Contrato::$rules);
    
        $input  = $request->all();
        
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
            
            Flash::error('No se pudo actualizar los datos laborales: ' . $e->getMessage());
            
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
