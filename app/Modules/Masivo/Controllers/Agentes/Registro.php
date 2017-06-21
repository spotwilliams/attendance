<?php

namespace Cat\Masivo\Controllers\Agentes;


use Cat\Http\Controllers\AppBaseController;
use Cat\Masivo\Services\Agentes\Procesador;
use Cat\Models\Base;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Krucas\Notification\Facades\Notification;
use Laracasts\Flash\Flash;

class Registro extends AppBaseController
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
        
        return view('Masivo::agentes.index');
    }
    
    public function upload(Request $request)
    {
        $rule = [
            'archivo' => 'required|mimetypes:application/vnd.ms-excel',
            'base'    => 'not_in:-1',
        
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
        try {
            return response()->download($request->input('file'));
        } catch (FileNotFoundException $e) {
            Flash::error('No se pudo descargar el archivo');
            
            return redirect(route('agentesMasivoIndex'));
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