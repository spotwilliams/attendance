<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContratoJAKOVCEVIC2018 extends Migration
{
    protected function getData(): array
    {
        return [
            'monto' => config('cat.monto_contrato'),
            'fecha_ingreso' => '2018-01-01',
            'id_estado_contrato' => 2, // id estado activo en la DB
            'id_tipo_contrato' => 8, // id locacion de servicios en la DB
            'fecha_ingreso_gobierno' => '2018-01-01',
            'comentario' => null,
            'fecha_estado_desde' => null,
            'fecha_estado_hasta' => null,
            'tipo_inscripcion' => 'Regimen simplificado',
            'fecha_fin' => '2018-12-31'
        ];
    }

    public function up()
    {
        // id de JAKOVCEVIC = 4468
        $agente = \Cat\Models\Agente::find(4468);

        // Only run if specific agent exists (requires seed data)
        if ($agente === null) {
            return;
        }

        $service = new \Cat\Modules\Agentes\Services\Registro\Store\Laborales($agente, $this->getData());
        $service->execute();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // id de JAKOVCEVIC = 4468
        $agente = \Cat\Models\Agente::find(4468);

        // Only run if specific agent exists (requires seed data)
        if ($agente === null) {
            return;
        }

        $data = $this->getData();

        /** @var \Illuminate\Database\Query\Builder $contrato */
        $contrato = \Cat\Models\Contrato::where('id_agente', '=', $agente->id);
        /** @var \Illuminate\Database\Query\Builder $contHist */
        $contHist = \Cat\Models\ContratoHistorico::where('id_agente', '=', $agente->id);

        foreach ($data as $field => $value) {
            $contrato->where($field, '=', $value);
            $contHist->where($field, '=', $value);
        }

        $contrato->forceDelete();
        $contHist->delete();
    }
}
