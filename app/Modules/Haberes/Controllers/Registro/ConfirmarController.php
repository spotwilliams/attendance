<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Calculo\CalculadorBatch;
use Cat\Modules\Haberes\Services\Helpers\Facilitador;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoAbierto;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Laracasts\Flash\Flash;
use Cat\Modules\Haberes\Controllers\Eloquenteable;

class ConfirmarController extends AppBaseController
{
    /** Trait que me permite generar reglas dinamicas para los campos factura */
    use Ruleable, Eloquenteable;
    
    /** @var string */
    protected $searchView;
    
    /** @var string */
    protected $confirmarView;
    
    /** @var string */
    protected $endView;
    
    /** @var string */
    protected $indexRoute;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->searchView    = 'Haberes::calculo.seleccionar-agentes';
        $this->indexRoute    = 'haberesIndex';
        $this->confirmarView = 'Haberes::calculo.confirmar-montos';
        $this->searchView    = 'Haberes::calculo.seleccionar-agentes';
        $this->endView       = 'Haberes::calculo.end';
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function registarFactura(Request $request)
    {
        $this->authorize('send', $this);
    
        try {
        $this->setRulesAccording()
            ->validate($request, $this->rules, $this->messages);
            
            /** @var Periodo $periodo */
            $periodo = Periodo::findOrFail($request->input('periodo'));
            
            $periodo->validarSiPuedeCalcular();
            
            $eloq = $this->getEloq($periodo, $request->input('agentes'));
            
            /** @var Collection $agentes */
            $agentes = $eloq->get();
            
            Facilitador::batch($agentes, $periodo);
            
            Flash::success('Facturacion registrada correctamente');
            
            return to_route($this->indexRoute);
            
        } catch (ValidationException $e) {
//
            Flash::error($e->validator->getMessageBag()->first());

//
            return $this->calcular($request);
        } catch (ModelNotFoundException $e) {
            Flash::error('Debe seleccionar un periodo');
            
            return to_route($this->indexRoute);
        } catch (PeriodoAbierto $e) {
            Flash::error($e->getMessage());
            
            return to_route($this->indexRoute);
        } catch (\Exception $exception) {
            Flash::error('Hubo un error inesperado durante la ejecución, intente nuevamente');
            
            return to_route($this->indexRoute);
            
        }
    }
    
    public function calcular(Request $request)
    {
//        $this->authorize('disclaimer', $this);
        
        try {
            /** @var Periodo $periodo */
            $periodo = Periodo::findOrFail($request->input('periodo'));
            
            $this->validate($request, ['agentes' => 'required'], ['required' => 'Debe seleccionar al menos un agente']);
            
            $periodo->validarSiPuedeCalcular();
            /** @var Builder $eloq */
            $eloq = $this->getEloq($periodo, $request->input('agentes'));
            
            /** @var Collection $agentes */
            $agentes    = $eloq->get();
            $calculador = new CalculadorBatch($agentes, $periodo);
            
            return view($this->confirmarView)
                ->with('periodo', $periodo)
                ->with('agentes', $calculador->execute());
            
        } catch (ValidationException $e) {
            Flash::error($e->validator->getMessageBag()->get('agentes')[0]);
            
            return view($this->searchView)
                ->with('periodo', $periodo);
        } catch (ModelNotFoundException $e) {
            Flash::error('Debe seleccionar un periodo');
            
            return to_route($this->indexRoute);
        } catch (PeriodoAbierto $e) {
            Flash::error($e->getMessage());
            
            return to_route($this->indexRoute);
        } catch (\Exception $exception) {
            Flash::error('Hubo un error inesperado durante la ejecución, intente nuevamente');
            
            return to_route($this->indexRoute);
            
        }
        
    }
}
