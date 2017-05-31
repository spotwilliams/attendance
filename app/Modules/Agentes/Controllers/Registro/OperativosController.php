<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Handlers\Error;
use Cat\Models\Agente;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Agentes\Services\Registro\Laborales;
use Cat\Modules\Agentes\Services\Registro\Personales;
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
        $input = $request->all();
        
        
        try {
            $agente  = Agente::find($input['agente']);
            $service = new Laborales($agente, $input);
            
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
        $agente = Agente::find($id);
        
        
        if (empty($agente)) {
            Flash::error('Agente no encontrado');
            
            return redirect(route('Agentes::registro.index'));
        }
        
        return view('Agentes::registro.edit')->with('agente', $agente);
    }
    
    /**
     * Update the specified Presentismo in storage.
     *
     * @param  int $id
     * @param UpdatePresentismoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePresentismoRequest $request)
    {
        $presentismo = $this->agenteRepository->findWithoutFail($id);
        
        if (empty($presentismo)) {
            Flash::error('Presentismo not found');
            
            return redirect(route('Presentismo::registro.index'));
        }
        
        $presentismo = $this->agenteRepository->update($request->all(), $id);
        
        Flash::success('Presentismo updated successfully.');
        
        return redirect(route('Presentismo::registro.index'));
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
