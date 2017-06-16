<?php

namespace Cat\Modules\Presentismo\Controllers\Registro;

use Cat\Models\Base;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Response;

class GeneralController extends AppBaseController
{
    /** @var  PresentismoRepository */
    private $presentismoRepository;
    
    public function __construct(PresentismoRepository $presentismoRepo)
    {
        $this->presentismoRepository = $presentismoRepo;
        $this->middleware('auth');
        
    }
    
    /**
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('Presentismo::registro.index');
    }
    
    public function prepareListaAgentes(Request $request)
    {
        $this->validate($request, ['base' => 'required|not_in:-1']);
        
        $input = $request->all();
        
        return redirect(route('presentismoListaAgentes',
            ['base' => $input['base'], 'desde' => $input['desde'], 'hasta' => $input['hasta']]));
        
    }
    
    public function listaAgentes(Request $request, $base, $desde, $hasta)
    {
        $input = ['desde' => $desde, 'hasta' => $hasta];
        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($input, [
            'hasta' => 'required|date_format:Y-m-d',
            'desde' => 'date_format:Y-m-d',
        ]);
        
        if ($validator->fails()) {
            dd($validator->errors());
            
            return redirect(route('presentismoIndex'));
        }

        try {
            
            $base    = Base::findOrFail($base);
            $desde   = new \DateTime($desde);
            $hasta   = new \DateTime($hasta);
            $agentes = $this->presentismoRepository
                ->getEloquentAgentesBetweenDates(
                    $base,
                    $desde,
                    $hasta
                );
            
        } catch (ModelNotFoundException $e) {
            Flash::error('Se ha seleccionado una base inexistente');
            
            return redirect(route('presentismoIndex'));
        }
        
        return view('Presentismo::registro.lista')
            ->with('desde', $desde)
            ->with('hasta', $hasta)
            ->with('baseActual', $base)
            ->with('agentes', $agentes->paginate(25));
    }
    
}
