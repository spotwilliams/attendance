<?php

namespace Cat\Modules\Haberes\Controllers\Notificacion;

use Cat\Models\Periodo;
use Cat\Modules\Haberes\Services\Calculo\CalculadorBatch;
use Cat\Modules\Presentismo\Exceptions\Validacion\PeriodoAbierto;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Cat\Modules\Haberes\Controllers\Registro\ConfirmarController as ParentController;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;

class ConfirmarController extends ParentController
{
    /** @var string */
    protected $emailView;
    
    /**
     * ConfirmarController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->searchView    = 'Haberes::notificacion.seleccionar-agentes';
        $this->indexRoute    = 'notificacionIndex';
        $this->confirmarView = 'Haberes::notificacion.seleccionar-agentes';
        $this->endView       = 'Haberes::notificacion.end';
    }
    
    public function regular(Request $request)
    {
        $condicions      = [];
        $this->emailView = 'Haberes::notificacion.email-regular';
        $periodo         = Periodo::findOrFail($request->input('periodo'));
        
        $condicions[] = [
            'where'    => 'whereDoesntHave',
            'column'   => 'notificaciones',
            'callable' => function ($whereHasNot) use ($periodo) {
                /** @var Builder $whereHasNot */
                $whereHasNot->where('id_periodo', '=', $periodo->id);
            },
        ];
        
        return $this->generateResponse($request, $condicions);
        
    }
    
    public function libre(Request $request)
    {
        $this->emailView = 'Haberes::notificacion.email-libre';
        
        return $this->generateResponse($request);
    }
    
    
    protected function generateResponse(Request $request, $eloqConditions = [])
    {
        try {
            /** @var Periodo $periodo */
            $periodo = Periodo::findOrFail($request->input('periodo'));
            
            $this->validate($request, ['agentes' => 'required'], ['required' => 'Debe seleccionar al menos un agente']);
            
            $periodo->validarSiPuedeCalcular();
            /** @var Builder $eloq */
            $eloq = $this->getEloq($periodo, $request->input('agentes'))
                ->with('operativo.base')
                ->with('operativo.turno');
            
            foreach ($eloqConditions as $condition) {
                $eloq->{$condition['where']}($condition['column'], $condition['callable']);
            }
            
            /** @var Collection $agentes */
            $agentes    = $eloq->get();
            $calculador = new CalculadorBatch($agentes, $periodo);
            
            return view($this->emailView)
                ->with('periodo', $periodo)
                ->with('agentes', $calculador->execute());
            
        } catch (ValidationException $e) {
            Flash::error($e->validator->getMessageBag()->get('agentes')[0]);
            
            return $this->calcular($request);
            
        } catch (ModelNotFoundException $e) {
            Flash::error('Debe seleccionar un periodo');
            
            return redirect()->route($this->indexRoute);
        } catch (PeriodoAbierto $e) {
            Flash::error($e->getMessage());
            
            return redirect()->route($this->indexRoute);
        } catch (\Exception $exception) {
            Log::error($exception);
            Flash::error('Hubo un error inesperado durante la ejecución, intente nuevamente');
            
            return redirect()->route($this->indexRoute);
            
        }
    }
    
}
