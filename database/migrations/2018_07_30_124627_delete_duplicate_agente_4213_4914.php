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
        try {
            
            $agenteNo = \Cat\Models\Agente::findOrFail(4914);
            
            $agenteSi = \Cat\Models\Agente::findOrFail(4213);
            
            $agenteNoData = $agenteNo->toArray();
            
            unset($agenteNoData['cuit']);
            $agenteSi->fill($agenteNoData)
                ->save();
            
            \Cat\Models\Agente::where('id', '=', 4914)
                ->delete();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        
        }
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
