<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Models\Agente;
use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Calculo\CalculadorBatch;
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
    /** Trait que me permite generar reglas dinamicas para los campos factura */
    use Ruleable;
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
    public function registarFactura(Request $request)
    {
        $this->authorize('batch', $this);
        
        try {
            
            /** @var Periodo $periodo */
            $periodo = Periodo::findOrFail($request->input('periodo'));
            
            $this->setRulesAccording($request)
                ->validate($request, $this->rules, $this->messages);
            
            $periodo->validarSiPuedeCalcular();
            
            
            dd($this);
            
            
            
        } catch (ValidationException $e) {
    
            Flash::error($e->validator->getMessageBag()->first());
            
            return $this->calcular($request);
            
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
    
}
