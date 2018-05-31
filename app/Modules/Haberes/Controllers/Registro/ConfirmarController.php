<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\EstadoPeriodo;
use Cat\Models\Periodo;
use Cat\Models\Turno;
use Cat\Modules\Haberes\Controllers\GeneralController;
use Cat\Modules\Haberes\Services\Calculo\CalculadorBatch;
use Cat\Modules\Haberes\Services\Helpers\Facilitador;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoAbierto;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Laracasts\Flash\Flash;

class ConfirmarController extends AppBaseController
{
    /** @var  PresentismoRepository */
    private $presentismoRepository;
    
    public function __construct(PresentismoRepository $presentismoRepo)
    {
        $this->presentismoRepository = $presentismoRepo;
        $this->middleware('auth');
        
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function calcular(Request $request)
    {
        $this->authorize('disclaimer', $this);
        
        try {
            /** @var Periodo $periodo */
            $periodo = Periodo::findOrFail($request->input('periodo'));
            
            $this->validate($request, ['agentes' => 'required'], ['required' => 'Debe seleccionar al menos un agente']);
            
            $periodo->validarSiPuedeCalcular();
            /** @var Builder $eloq */
            $eloq = Agente::whereIn('id', $request->input('agentes'))
                ->with([
                    'presentismos' => function ($with) use ($periodo) {
                        /** @var Builder $with */
                        $with->where('id_periodo', '=', $periodo->id)
                            ->with('turno')
                            ->with('tipoPresentismo')
                            ->with('tipoContrato');
                    },
                ]);
            
            /** @var Collection $agentes */
            $agentes    = $eloq->get();
            $calculador = new CalculadorBatch($agentes, $periodo);
            
            $calculador->execute();
            
            
            return view('Haberes::calculo.confirmar-montos')
                ->with('periodo', $periodo)
                ->with('agentes', $calculador->execute());
            
        } catch (ValidationException $e) {
            Flash::error($e->validator->getMessageBag()->get('agentes')[0]);
            
            return view('Haberes::calculo.seleccionar-agentes')
                ->with('periodo', $periodo);
        } catch (ModelNotFoundException $e) {
            Flash::error('Debe seleccionar un periodo');
            
            return redirect()->route('haberesIndex');
        } catch (PeriodoAbierto $e) {
            Flash::error($e->getMessage());
            
            return redirect()->route('haberesIndex');
        } catch (\Exception $exception) {
            Flash::error('Hubo un error inesperado durante la ejecución, intente nuevamente');
            
            return redirect()->route('haberesIndex');
            
        }
        
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function batch(Request $request)
    {
        $this->authorize('batch', $this);
        
        try {
            $input   = $request->all();
            $periodo = Periodo::findOrFail($input['periodo']);
            $base    = Base::find($input['base']);
            $turno   = Turno::findOrFail($input['turno']);
            
            $estadoPeriodo = EstadoPeriodo::where('id_periodo', '=', $periodo->id)
                ->where('id_base', '=', $base->id)
                ->where('id_turno', '=', $turno->id)
                ->first();
            
            Facilitador::batch($base, $periodo, $turno);
            Flash::success('Periodo cerrado con &eacute;xito');
            
            return view('Haberes::calculo.end')
                ->with('periodo', $periodo)
                ->with('base', $base)
                ->with('estadoPeriodo', $estadoPeriodo)
                ->with('turno', $turno);
            
        } catch (ModelNotFoundException $exception) {
            Flash::error('Hubo un error durante la ejecución. Intente nuevamente');
            
            return redirect()->back();
            
        }
    }
    
}
