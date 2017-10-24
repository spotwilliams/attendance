<?php

namespace Cat\Policies;

use Cat\Models\Agente;
use Cat\Models\TipoContrato;
use Cat\Models\TipoPresentismo;
use Cat\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TipoPresentismoGatePolicy extends SecurityPolicy
{
    public function __construct()
    {
        $specialPermissions = [
            'LOCACION'          => [
                'N'    => 'Justificar licencia N - LOCACION',
                'AT'   => 'Justificar licencia AT',
                'EXMA' => 'Justificar licencia EXMA - LOCACION',
                'ML'    => 'Justificar licencia M - LOCACION',
            ],
            'SITUACION_REVISTA' => [],
            'TODOS'             => [
                'M'   => 'Justificar licencia M',
                'LES' => 'Justificar licencia LES',
            
            ],
        ];
        parent::__construct($specialPermissions);
    }
    
    public function licencia(User $user, Agente $agente, TipoPresentismo $tipo)
    {
        try {
            /** @var TipoContrato $tipoContrato */
            $tipoContrato = $agente->contrato()->firstOrFail()->tipoContrato()->firstOrFail();
            if (isset($this->specialPermissions[$tipoContrato->codigo])) {
                if (isset($this->specialPermissions[$tipoContrato->codigo][$tipo->codigo])) {
                    
                    
                    $hasAccess = $this->verifyOnlyControllerPermission(
                        $user,
                        $this->specialPermissions[$tipoContrato->codigo][$tipo->codigo]
                    );
                    
                    return $hasAccess;
                } else {
                    return true;
                }
            } else {
                // Si no hay un permiso registrado entonces no puedo controlar
                return true;
            }
        } catch (ModelNotFoundException $e) {
            // Si el agente no tiene un contrato asignado no puedo verificar nada
            return true;
        }
    }
    
    
}