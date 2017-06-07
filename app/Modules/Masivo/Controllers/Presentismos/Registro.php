<?php

namespace Cat\Masivo\Controllers\Presentismos;


use Cat\Http\Controllers\AppBaseController;
use Cat\Masivo\Services\Presentismos\Procesador;
use Cat\Models\Base;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class Registro extends AppBaseController
{
    
    public function __construct()
    {
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
        
        return view('Masivo::presentismos.index')
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
        
        return view('Masivo::presentismos.end-process');
    }
    
    public function downloadErrores(Request $request)
    {
        return response()->download($request->input('file'));
    }
    
}