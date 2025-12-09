<?php

namespace Cat\Modules\Masivo\Controllers\Presentismos;


use Cat\Http\Controllers\AppBaseController;
use Cat\Modules\Masivo\Services\Presentismos\Procesador;
use Cat\Modules\Masivo\Services\Presentismos\Generator;
use Cat\Models\Base;
use Cat\Models\Turno;
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
        $this->authorize('index', $this);
        
        return view('Masivo::presentismos.index-params');
    }
    
    public function selectFile(Request $request)
    {
        $this->authorize('selectFile', $this);
        
        $rule = [
            'base'  => 'not_in:-1',
            'turno' => 'not_in:-1',
        
        ];
        $this->validate($request, $rule);
        
        // Se autorizan las bases y turnos
        $this->authorize('base', $request);
        $this->authorize('turno', $request);
        
        try {
            $input = $request->all();
            $base  = Base::findOrFail($input['base']);
            $turno = Turno::findOrFail($input['turno']);
            
            $service = new Generator($base, $turno);
            $service->execute();
            
            $fileName = $service->getFileName();
            
            return view('Masivo::presentismos.index-file')
                ->with('base', $base)
                ->with('turno', $turno)
                ->with('file', $fileName);
            
        } catch (ModelNotFoundException $e) {
            Flash::error('Seleccione nuevamente la base y el turno.');
            
            return redirect(route('presentismosMasivoIndex'));
        }
        
    }
    
    public function upload(Request $request)
    {
        try {
            $rule = [
                'archivo' => 'required',
            
            ];
            
            $this->validate($request, $rule);
            
            $input   = $request->all();
            $base    = Base::find($input['base']);
            $turno   = Turno::find($input['turno']);
            $file    = $request->file('archivo');
            $service = new Procesador($base, $file);
            
            $service->execute();
            
        } catch (ValidationException $fileNotFound) {
            Flash::error('Verifique que el archivo tengo la extensi&oacute;n correcta.');
            
            return redirect(route('presentismosMasivoIndex'));
        } catch (\Exception $e) {
            Flash::error($e->getMessage());
            
            return redirect(route('presentismosMasivoIndex'));
            
        }
        
        return view('Masivo::presentismos.end-process')
            ->with('base', $base)
            ->with('turno', $turno);
    }
    
    public function downloadErrores(Request $request)
    {
        $this->authorize('downloadErrores', $this);
        
        return response()->download($request->input('file'));
    }
    
    public function downloadTemplate(Request $request, $fileName)
    {
        $this->authorize('downloadTemplate', $this);
        
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
