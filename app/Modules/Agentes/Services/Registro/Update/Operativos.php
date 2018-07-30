<?php

namespace Cat\Modules\Agentes\Services\Registro\Update;


use Carbon\Carbon;
use Cat\Models\Agente;
use Cat\Models\Area;
use Cat\Models\Base;
use Cat\Models\Cargo;
use Cat\Models\Contrato;
use Cat\Models\DiaDisponible;
use Cat\Models\Domicilio;
use Cat\Models\EstadoContrato;
use Cat\Models\Estudio;
use Cat\Models\Funcion;
use Cat\Models\Gerencia;
use Cat\Models\Horario;
use Cat\Models\JornadaLaborable;
use Cat\Models\Operativo;
use Cat\Models\Presentismo;
use Cat\Models\TipoContrato;
use Cat\Models\TipoPresentismo;
use Cat\Models\Turno;
use Cat\Models\TurnoHistorico;
use Cat\Modules\Service;
use Cat\Repositories\JornadaLaborableRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Operativos extends Service
{
    /** @var Agente */
    protected $agente;
    
    /** @var  Gerencia */
    protected $gerencia;
    
    /** @var  Area */
    protected $area;
    
    /** @var  Cargo */
    protected $cargo;
    
    /** @var  Funcion */
    protected $funcion;
    
    /** @var  Base */
    protected $base;
    
    /** @var  Turno */
    protected $turno;
    
    /** @var  Horario */
    protected $horario;
    
    protected $funcion_especifica;
    
    public function __construct($agente, $input)
    {
        $this->agente             = Agente::findOrFail($input['agente']);
        $this->gerencia           = $this->getMockModelWhenNull(Gerencia::class, $input['id_gerencia']);
        $this->area               = $this->getMockModelWhenNull(Area::class, $input['id_area']);
        $this->cargo              = $this->getMockModelWhenNull(Cargo::class, $input['id_cargo']);
        $this->funcion_especifica = $input['funcion_especifica'];
        $this->funcion            = Funcion::findOrFail($input['id_funcion']);
        $this->base               = Base::findOrFail($input['id_base']);
        $this->turno              = Turno::findOrFail($input['id_turno']);
        $this->horario            = [
            'hora_entrada' => $input['hora_entrada'],
            'hora_salida'  => $input['hora_salida'],
            'eximido'      => ($input['eximido'] == 1 ? true : false),
            'rotativo'     => ($input['rotativo'] == 1 ? true : false),
        ];
    }
    
    public function execute()
    {
        
        $preliminarData = [
            'id_agente'          => $this->agente->id,
            'id_gerencia'        => $this->gerencia->id,
            'id_base'            => $this->base->id,
            'id_area'            => $this->area->id,
            'funcion_especifica' => $this->funcion_especifica,
            'id_cargo'           => $this->cargo->id,
            'id_funcion'         => $this->funcion->id,
            'id_turno'           => $this->turno->id,
        ];
        try {
            DB::beginTransaction();
            try {
                
                /** @var Operativo $operativo */
                $operativo = $this->agente
                    ->operativo()
                    ->firstOrFail();
                $operativo->update($preliminarData);
                
                
            } catch (ModelNotFoundException $e) {
                $horario                      = Horario::create($this->horario);
                $preliminarData['id_horario'] = $horario->id;
                $operativo                    = Operativo::create($preliminarData);
            }
            
            // A partir de aqui Operativo siempre existe
            try {
                $operativo
                    ->horario()
                    ->firstOrFail()
                    ->update(
                        $this->horario
                    );
            } catch (ModelNotFoundException $sinHorario) {
                $horario = Horario::create($this->horario);
                $operativo->update(['id_horario' => $horario->id]);
            }
            
            $this->logCambioTurno($operativo);
            
            DB::commit();
            
            return $this->agente;
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    
    protected function logCambioTurno(Operativo $operativo)
    {
        $today = Carbon::now();
        try {
            
            /** @var  TurnoHistorico $tHistorico */
            $tHistorico = TurnoHistorico::where('id_operativo', '=', $operativo->id)
                ->whereDate('fecha_fin', '>=', $today)
                ->orderBy('id', 'DESC')
                ->firstOrFail();
            
            // Update del actual en los historicos
            $tHistorico->update([
                'fecha_fin' => Carbon::yesterday()->format('Y-m-d'),
            ]);
        } catch (ModelNotFoundException $sinHistorico) {
        
        
        }
        // Registro del nuevo valor actual en los historicos
        TurnoHistorico::create([
            'id_operativo' => $operativo->id,
            'id_turno'     => $this->turno->id,
            'fecha_inicio' => Carbon::now()->format('Y-m-d'),
        ]);
        
        // Se elimina la basura (todos aquellos registros generados en un mismo dia)
        TurnoHistorico::where('fecha_inicio', '>', DB::raw('fecha_fin'))
            ->delete();
    }
    
}