<?php

namespace Cat\Masivo\Controllers\Agentes;


use Cat\Http\Controllers\AppBaseController;
use Cat\Masivo\Services\Agentes\DuplicadoProcesador;
use Cat\Models\Base;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class Duplicados extends AppBaseController
{
    /** @var  AgenteRepository */
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    /**
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
//        $this->authorize('index', $this);
        
        return view('Masivo::agentes.duplicado.index');
    }
    
    public function upload(Request $request)
    {
        
        $rule = [
            'archivo' => 'required',
        
        ];
        $this->validate($request, $rule);
        
        $input = $request->all();
        
        try {
            $file    = $request->file('archivo');
            $service = new DuplicadoProcesador(new Base(), $file);
            
            $service->execute();
            
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
        }
        
        return view('Masivo::agentes.duplicado.end-process');
    }
    
    public function downloadErrores(Request $request)
    {
        
        try {
            return response()->download($request->input('file'));
        } catch (FileNotFoundException $e) {
            Flash::error('No se pudo descargar el archivo');
            
            return redirect(route('agentesMasivoDuplicadoIndex'));
        }
        
    }
    
    
    public function downloadTemplate(Request $request)
    {
        
        return response()
            ->download(Storage::disk('masivos_template')
                    ->getDriver()
                    ->getAdapter()
                    ->getPathPrefix() . 'agentes_masivo_template.xls');
    }
    
}