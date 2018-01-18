<?php

namespace Cat\Masivo\Controllers\Presentismos;


use Cat\Http\Controllers\AppBaseController;
use Cat\Masivo\Services\Presentismos\MigracionProcesador;
use Cat\Models\Base;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class Migracion extends AppBaseController
{
    protected $repository;
    
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
    public function index(Request $request)
    {
        
        return view('Masivo::presentismos.migracion.index-file');
    }
    
    public function upload(Request $request)
    {
        try {

            $file    = $request->file('archivo');
            $service = new MigracionProcesador(new Base(), $file);
            
            $service->execute();
            
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            
            return redirect(route('presentismosMasivoMigracionIndex'));
            
        }
        
        return view('Masivo::presentismos.migracion.end-process');
    }
    
    public function downloadErrores(Request $request)
    {
        
        return response()->download($request->input('file'));
    }
    
}