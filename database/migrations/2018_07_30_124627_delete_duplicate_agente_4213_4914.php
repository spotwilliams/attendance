<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteDuplicateAgente42134914 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $agenteNo = \Cat\Models\Agente::find(4914);
        
        $agenteSi = \Cat\Models\Agente::find(4213);
        
        $agenteNoData = $agenteNo->toArray();
        
        unset($agenteNoData['cuit']);
        $agenteSi->fill($agenteNoData)
            ->save();
        
        \Cat\Models\Agente::where('id', '=', 4914)
            ->delete();
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
