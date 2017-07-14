<?php

namespace Cat\Masivo\Controllers\Inicial;


use Cat\Http\Controllers\AppBaseController;
use Cat\Masivo\Services\Inicial\Procesador;
use Cat\Models\TipoPresentismo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class Registro extends AppBaseController
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
        
        return view('Masivo::inicial.index-params');
    }
    
    public function selectFile(Request $request)
    {
        try {
            $input        = $request->all();
            $tPresentismo = TipoPresentismo::findOrFail($input['tipo']);
            
            
            return view('Masivo::inicial.index-file')
                ->with('tipo', $tPresentismo);
            
        } catch (ModelNotFoundException $e) {
            Flash::error($e->getMessage());
            
            return redirect(route('presentismosInicialMasivoIndex'));
        }
        
    }
    
    public function upload(Request $request)
    {
        
        try {
            $input   = $request->all();
            $tipo    = TipoPresentismo::find($input['tipo']);
            $file    = $request->file('archivo');
            $service = new Procesador($tipo, $file, 'presentismos');
            
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
    
    public function downloadTemplate(Request $request, $fileName)
    {
        try {
            
            $route = Storage::disk('masivo')
                ->getDriver()
                ->getAdapter()
                ->getPathPrefix();
            $route .= 'presentismos/' . $fileName;
            
            return response()->download($route);
        } catch (FileNotFoundException $e) {
            Flash::error('No se pudo descargar el archivo de la base. Intente nuevamente.');
            
            return redirect(route('presentismosMasivoIndex'));
        }
    }
    
}