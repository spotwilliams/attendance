<?php

namespace Cat\Modules\Agentes\Services\Registro\Update;


use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Modules\Agentes\Services\Registro\Traits\LaboralesSetup;
use Cat\Modules\Service;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Laborales extends Service
{
    
    use LaboralesSetup;
    
    public function __construct(Agente $agente, $input)
    {
        // Shared with Store
        $this->setup($agente, $input);
    }
    
    
    public function execute()
    {
        // Es el ultimo contrato que se registro
        
        try {
            DB::beginTransaction();
            
            
            $contratoActual = $this->agente
                ->contrato()
                ->with('estadoContrato')
                ->with('tipoContrato')
                ->orderBy('id', 'DESC')
                ->firstOrFail();
            
            if (($contratoActual->tipoContrato->id === $this->tipo->id)
                and ($contratoActual->estadoContrato->id === $this->estado->id)) {
                $this->mantenerContrato($contratoActual);
            } else {
                $this->createNewContrato($contratoActual);
            }
            
            DB::commit();
            
            return $this->agente;
            
            
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        }
        
    }
    
    public function createNewContrato(Contrato $contratoActual)
    {
        $data = $this->getData();
        
        // Hay que darle un posible cierre al contrato actual
        // y comienzo al nuevo contrato, tal vez sin necesidad de cierre
        
        // 1) damos cierre al contrato actual, desde el dia anterior al contrato actual
        if ($contratoActual->tipoContrato->id !== $this->tipo->id) {
            
            $fechaFin = new \DateTime($this->fecha->format('Y-m-d'));
            $fechaFin->modify('-1day');
            
            $contratoActual->update([
                'fecha_fin' => $fechaFin->format('Y-m-d'),
            ]);
        }
        
        Contrato::create(array_filter($data));
    }
    
    public function mantenerContrato(Contrato $contratoActual)
    {
        $data = $this->getData();
        
        $contratoActual->update(array_filter($data));
        
        
    }
    
}