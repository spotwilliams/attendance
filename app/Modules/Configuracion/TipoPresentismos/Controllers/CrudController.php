<?php

namespace Cat\Modules\Configuracion\TipoPresentismos\Controllers;

use Cat\Helpers\Cache;
use Cat\Models\DiaPermitido;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Configuracion\TipoPresentismos\Requests\CreateTipoPresentismoRequest;
use Cat\Modules\Configuracion\TipoPresentismos\Requests\UpdateTipoPresentismoRequest;
use Cat\Modules\Configuracion\TipoPresentismos\Repositories\TipoPresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Illuminate\View\View;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Http\Response;

class CrudController extends AppBaseController
{
    /** @var  TipoPresentismoRepository */
    private $repository;
    
    protected $meses
        = [
            'JULY',
            'AUGUST',
            'SEPTEMBER',
            'OCTOBER',
            'NOVEMBER',
            'DECEMBER',
        ];
    
    public function __construct(TipoPresentismoRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Display a listing of the Area.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $this->authorize('index', $this);
        
        $this->repository->pushCriteria(new RequestCriteria($request));
        $tipos = TipoPresentismo::where('aplica', '<>', '')->get();
        
        
        return view('Configuracion::tipo_presentismo.index')
            ->with('tipos', $tipos);
    }
    
    /**
     * Show the form for creating a new Area.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', $this);
        
        return view('Configuracion::tipo_presentismo.create');
    }
    
    /**
     * Store a newly created Area in storage.
     *
     * @param CreateAreaRequest $request
     *
     * @return Response
     */
    public function store(CreateTipoPresentismoRequest $request)
    {
        $this->authorize('store', $this);
        
        try {
            $input = $request->all();
            $tp    = TipoPresentismo::create($input);
            if ($input['tiene_tope'] == '1') {
                $valueMonth = 7;
                
                foreach ($this->meses as $mes) {
                    if ($mes == 'JULY') {
                        $prop = $input['dias_permitidos'];
                    } else {
                        $prop = $this->calculate($valueMonth, (int)$input['dias_permitidos']);
                    }
                    
                    DiaPermitido::create([
                        'mes_ingreso'         => $mes,
                        'cant_semanal'        => $prop,
                        'cant_fin_semana'     => $prop,
                        'id_tipo_presentismo' => $tp->id,
                    ]);
                }
            }
            Cache::flush();
            
            Flash::success('Licencia guardada correctamente.');
        } catch (\Exception $e) {
            
            Flash::error('No se pudo guardar el tipo de licencia.');
        }
        
        return redirect(route('configuracion.licencia.index'));
    }
    
    
    /**
     * Show the form for editing the specified Area.
     *
     * @param  int $id
     *
     * @return View
     */
    public function edit($id)
    {
        $this->authorize('edit', $this);
        
        $tipo = $this->repository->findWithoutFail($id);
        
        if (empty($tipo)) {
            Flash::error('Tipo de licencia no encontrada');
            
            return redirect(route('configuracion.licencia.index'));
        }
        
        return view('Configuracion::tipo_presentismo.edit')->with('tipo', $tipo);
    }
    
    
    public function update(UpdateTipoPresentismoRequest $request)
    {
        $this->authorize('update', $this);
        
        try {
            $input = $request->all();
            $tp    = TipoPresentismo::findOrFail($input['id']);
            $tp->update([
                'descripcion'   => $input['descripcion'],
                'codigo'        => $input['codigo'],
                'color'         => $input['color'],
                'color_letra'   => $input['color_letra'],
                'aplica'        => $input['aplica'],
                'injustificado' => $input['injustificado'],
            ]);
            if ($input['tiene_tope'] == '1') {
                $valueMonth = 6;
                
                foreach ($this->meses as $mes) {
                    if ($mes == 'JULY') {
                        $prop = $input['dias_permitidos'];
                    } else {
                        $prop = $this->calculate($valueMonth, (int)$input['dias_permitidos']);
                    }
                    DiaPermitido::firstOrCreate([
                        'mes_ingreso'         => $mes,
                        'id_tipo_presentismo' => $tp->id,
                    ])
                        ->update([
                            'cant_semanal'    => $prop,
                            'cant_fin_semana' => $prop,
                        ]);
                    $valueMonth++;
                }
            } else {
                DiaPermitido::where('id_tipo_presentismo', '=', $tp->id)
                    ->delete();
            }
            Cache::flush();
            Flash::success('Tipo de licencia actualizada correctamente.');
        } catch (\Exception $e) {
            dd($e);
            Flash::error('No se pudo guardar el tipo de licencia.');
        }
        
        return redirect(route('configuracion.licencia.index'));
    }
    
    protected function calculate($mes, $montoReferencia)
    {
        $prop = (float)((((int)$montoReferencia) / 12) * (12 - $mes));
        
        
        return (int)ceil($prop);
        
    }
}
