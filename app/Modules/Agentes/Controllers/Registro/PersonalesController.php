<?php

namespace Cat\Modules\Agentes\Controllers\Registro;

use Cat\Handlers\Error;
use Cat\Models\Agente;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Agentes\Services\Registro\Store\Personales as Store;
use Cat\Modules\Agentes\Services\Registro\Update\Personales as Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Response;

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
     * Show the form for creating a new Presentismo.
     *
     * @return Response
     */
    public function create()
    {
        return view('Agentes::registro.create')
            ->with('tab', 'personales');
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
        $this->validate($request, Agente::$rules);
        
        $agente = new Agente($input);
        
        try {
            $service = new Store($agente, $input['domicilio'], $input['estudio']);
            $service->execute();
            
            return redirect(route('agentesCreateLaborales', ['id' => $agente->id]));
        } catch (\Exception $e) {

            Flash::error('No se pudo guadar los datos personales: ' . $e->getMessage());
    
            return redirect(route('agentesCreatePersonales'))
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
            
            return redirect(route('agentesCreatePersonales'));
        }
        
        return view('Agentes::registro.edit')
            ->with('agente', $agente)
            ->with('tab', 'personales');
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
        $this->validate($request, Agente::$rules);
        $input  = $request->all();
        $agente = Agente::find($input['id']);
        
        if (empty($agente)) {
            Flash::error('Agente no encontrado');
            
            return redirect(route('agentesIndex', ['base', 1]));
        }
        
        try {

            $service = new Update($agente, $input);
            $service->execute();
            Flash::success('Datos personales actualizados correctamente.');
            
            return redirect(route('agentesEditLaborales', ['id' => $agente->id]));
            
            
        } catch (\Exception $e) {
            
            Flash::error('No se pudo actualizar los datos personales: ' . $e->getMessage());
            
            return redirect(route('agentesEditPersonales', ['id' => $agente->id]));
            
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
