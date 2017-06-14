<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Handlers\Error;
use Cat\Models\Agente;
use Cat\Models\Operativo;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Agentes\Services\Registro\Store\Operativos as Store;
use Cat\Modules\Agentes\Services\Registro\Update\Operativos as Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Response;

class OperativosController extends AppBaseController
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
            ->with('tab', 'operativos')
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
        
        $this->validate($request, Operativo::$rules);
        
        $input = $request->all();
        
        try {
            
            $service = new Store($input);
            
            $service->execute();
            
            return redirect(route('agentesShow', ['id' => $input['agente']]));
        } catch (\Exception $e) {
            
            $validator = Validator::make(['operacion' => null], ['operation |required']);
            $validator->after(function ($validator) use ($e) {
                $validator->errors()->add('operacion', Error::getRespuestaAdecuada($e, 'agente'));
            });
            
            return redirect(route('agentesCreateOperativos', ['id' => $input['agente']]))
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
            ->with('operativo', $agente->operativo()->first())
            ->with('tab', 'operativos');
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
        $this->validate($request, Operativo::$rules);
        
        $input  = $request->all();
        $agente = Agente::find($input['agente']);
        
        if (empty($agente)) {
            Flash::error('Agente no encontrado');
            
            return redirect(route('agentesIndex', ['base', 1]));
        }
        
        try {
            
            $service = new Update($agente, $input);
            $service->execute();
            Flash::success('Datos operativos actualizados correctamente.');
            
            return redirect(route('agentesShow', ['id' => $agente->id]));
            
            
        } catch (\Exception $e) {
            
            Flash::error('No se pudo actualizar los datos operativos: ' . $e->getMessage());
            
            return redirect(route('agentesEditOperativos', ['id' => $agente->id]));
            
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
