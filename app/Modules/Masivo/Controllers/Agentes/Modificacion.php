<?php

namespace Cat\Masivo\Controllers\Agentes;


use Cat\Http\Controllers\AppBaseController;
use Cat\Masivo\Services\Agentes\ModificacionProcesador;
use Cat\Models\Base;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class Modificacion extends AppBaseController
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
        
        return view('Masivo::agentes.index');
    }
    
    public function upload(Request $request)
    {
//        $this->authorize('upload', $this);
        
        $rule = [
            'archivo' => 'required',
            'base'    => 'not_in:-1',
        
        ];
        $this->validate($request, $rule);
        
        $input = $request->all();
        $base  = Base::find($input['base']);
        Gate::allows('work-bases', [[$base->id]]);
        
        try {
            $file    = $request->file('archivo');
            $service = new ModificacionProcesador($base, $file);
            
            $service->execute();
            
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
        }
        
        return view('Masivo::agentes.end-process');
    }
    
    public function downloadErrores(Request $request)
    {
//        $this->authorize('downloadErrores', $this);
        
        try {
            return response()->download($request->input('file'));
        } catch (FileNotFoundException $e) {
            Flash::error('No se pudo descargar el archivo');
            
            return redirect(route('agentesMasivoIndex'));
        }
        
    }
    
    
    public function downloadTemplate(Request $request)
    {
//        $this->authorize('downloadTemplate', $this);
        
        return response()
            ->download(Storage::disk('masivos_template')
                    ->getDriver()
                    ->getAdapter()
                    ->getPathPrefix() . 'agentes_masivo_template.xls');
    }
    
}