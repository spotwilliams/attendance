<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContratoJAKOVCEVIC2018 extends Migration
{
    /** @var \Cat\Models\Agente */
    protected $agente;
    /** @var array  */
    protected $data;

    public function __construct()
    {
        // id de JAKOVCEVIC = 4468
        $this->agente = \Cat\Models\Agente::findOrFail(4468);
        $this->data = [
                'monto' => config('cat.monto_contrato'),
                'fecha_ingreso' => '2018-01-01',
                'id_estado_contrato' => 1, // id estado activo en la DB
                'id_tipo_contrato' => 8, // id locacion de servicios en la DB
                'fecha_ingreso_gobierno' => '2018-01-01',
//                'id_sial' => 'xxx',
//                'ficha' => '',
                'tipo_inscripcion' => 'Regimen simplificado',
                'fecha_fin' => '2018-12-31'
        ];
    }


    public function up()
    {

        $service = new \Cat\Modules\Agentes\Services\Registro\Store\Laborales($this->agente, $this->data);

        $service->execute();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /** @var \Illuminate\Database\Query\Builder $contrato */
        $contrato = \Cat\Models\Contrato::where('id_agente', '=', $this->agente->id);
        /** @var \Illuminate\Database\Query\Builder $contHist */
        $contHist = \Cat\Models\ContratoHistorico::where('id_agente', '=', $this->agente->id);

        foreach ($this->data as $field => $value) {
            $contrato->where($field, '=', $value);
            $contHist->where($field, '=', $value);
        }

        $contrato->forceDelete();
        $contHist->delete();
    }
}
