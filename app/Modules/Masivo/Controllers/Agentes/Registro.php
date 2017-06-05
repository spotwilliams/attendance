<?php

namespace Cat\Masivo\Controllers\Agentes;


use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Illuminate\Http\Request;

class Registro extends AppBaseController
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
     * @return Response
     */
    public function index(Request $request, $base)
    {
        
        return view('Masivo::agentes.index')
            ->with('baseActual', $base);
    }
}