<?php

namespace Cat\Masivo\Controllers\Agentes;


use Cat\Http\Controllers\AppBaseController;
use Cat\Masivo\Services\Agentes\Procesador;
use Cat\Models\Base;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Illuminate\Http\Request;
use Krucas\Notification\Facades\Notification;
use Laracasts\Flash\Flash;

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
    
    public function upload(Request $request)
    {
        $rule = [
            'archivo' => 'required|mimetypes:text/plain',
        
        ];
        $this->validate($request, $rule);
        
        try {
            $input   = $request->all();
            $base    = Base::find($input['base']);
            $file    = $request->file('archivo');
            $service = new Procesador($base, $file);
            
            $service->execute();
            
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
        }
        
        return view('Masivo::agentes.end-process');
    }
    
    public function downloadErrores(Request $request)
    {
        return response()->download($request->input('file'));
    }
    
}