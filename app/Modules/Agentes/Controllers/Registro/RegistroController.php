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
     * @param Request $request
     * @param $base
     * @return $this
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request, $base)
    {
        $this->authorize('index', $this);
        $agentes = $this->agenteRepository->getAgentesByBase($base);
        
        return view('Agentes::registro.index')
            ->with('baseActual', $base)
            ->with('agentes', $agentes);
    }
    
    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $this->authorize('show', $this);
        
        try {
            // Se verifica que el agente exista
            $agente = Agente::findOrFail($id);

            return view('Agentes::registro.show')
                ->with('agente', $agente);
        } catch (ModelNotFoundException $e) {
            abort(404);
        } catch (\Exception $e) {
            Flash::warning('Agente inexistente');

            return redirect(route('agentesSearchIndex'));
        }
        
    }
}
