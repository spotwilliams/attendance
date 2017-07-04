<?php

namespace Cat\Modules\Agentes\Services\Registro\Update;


use Cat\Models\Agente;
use Cat\Models\DiaDisponible;
use Cat\Models\Domicilio;
use Cat\Models\Estudio;
use Cat\Models\JornadaLaborable;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Agentes\Services\Registro\CheckEstudiosAndDomicilio;
use Cat\Modules\Service;
use Cat\Repositories\JornadaLaborableRepository;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Personales extends Service
{
    use CheckEstudiosAndDomicilio;
    /** @var Agente */
    protected $agente;
    
    /** @var array */
    protected $domicilios;
    
    /** @var array */
    protected $estudios;
    /** @var  array */
    protected $input;
    
    
    public function __construct(Agente $agente, $input)
    {
        $this->agente     = $agente;
        $this->domicilios = $input['domicilio'];
        $this->estudios   = $input['estudio'];
        $this->input      = $input;
    }
    
    public function execute()
    {
        try {
            
            DB::beginTransaction();
            
            $this->agente->update($this->input);
            $this->workWithDomicilios();
            $this->workWithEstudios();
            
            DB::commit();
            
            return $this->agente;
        } catch (QueryException $e) {
            
            DB::rollBack();
            throw $e;
        }
    }
    
    private function workWithDomicilios()
    {
        $notDeleteThis = array_filter(array_values($this->domicilios['id']));
        if (!empty($notDeleteThis)) {
            Domicilio::whereNotIn('id', $notDeleteThis)
                ->delete();
        }
        for ($i = 0; $i < count($this->domicilios['calle']); $i++) {
            if ($this->hasSomeUsefullData($this->domicilios, $i, ['constituido'])) {
                
                if ($this->domicilios['id'][$i] !== '') {
                    $domicilio = Domicilio::find($this->domicilios['id'][$i]);
                    if (!empty($domicilio)) {
                        
                        /** @var Domicilio $domicilio */
                        $domicilio->update([
                            'calle'        => $this->domicilios['calle'][$i],
                            'numero'       => $this->domicilios['numero'][$i],
                            'departamento' => $this->domicilios['departamento'][$i],
                            'piso'         => $this->domicilios['piso'][$i],
                            'barrio'       => $this->domicilios['barrio'][$i],
                            'provincia'    => $this->domicilios['provincia'][$i],
                            'constituido'  => $this->domicilios['constituido'][$i],
                            'libre'        => $this->domicilios['libre'][$i],
                        ]);
                        
                    }
                } else {
                    Domicilio::create([
                        'id_agente'    => $this->agente->id,
                        'calle'        => $this->domicilios['calle'][$i],
                        'numero'       => $this->domicilios['numero'][$i],
                        'departamento' => $this->domicilios['departamento'][$i],
                        'piso'         => $this->domicilios['piso'][$i],
                        'barrio'       => $this->domicilios['barrio'][$i],
                        'provincia'    => $this->domicilios['provincia'][$i],
                        'constituido'  => $this->domicilios['constituido'][$i],
                        'libre'        => $this->domicilios['libre'][$i],
                    ]);
                }
            }
        }
    }
    
    private function workWithEstudios()
    {
        
        $notDeleteThis = array_filter(array_values($this->estudios['id']));
        if (!empty($notDeleteThis)) {
            Estudio::whereNotIn('id', $notDeleteThis)
                ->delete();
        }
        for ($i = 0; $i < count($this->estudios['carrera']); $i++) {
            if ($this->hasSomeUsefullData($this->estudios, $i, ['estado', 'nivelestudio'])) {
                
                if ($this->estudios['id'][$i] !== '') {
                    /** @var Estudio $estudio */
                    $estudio = Estudio::find($this->estudios['id'][$i]);
                    if (!empty($estudio)) {
                        
                        $estudio->update([
                            'carrera'     => $this->estudios['carrera'][$i],
                            'institucion' => $this->estudios['institucion'][$i],
                            'estado'      => $this->estudios['estado'][$i],
                            'nivel'       => $this->estudios['nivelestudio'][$i],
                        ]);
                    }
                } else {
                    Estudio::create([
                        'id_agente'   => $this->agente->id,
                        'carrera'     => $this->estudios['carrera'][$i],
                        'institucion' => $this->estudios['institucion'][$i],
                        'estado'      => $this->estudios['estado'][$i],
                        'nivel'       => $this->estudios['nivelestudio'][$i],
                    ]);
                }
            }
        }
    }
    
    
}