<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToPresentismoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::table('presentismos', function (Blueprint $table) {
            
            $table->integer('id_tipo_contrato')->index('presentismo_tiene_tipo_contrato_idx')->nullable();
            $table->integer('id_estado_contrato')->index('presentismo_tiene_estado_contrato_idx')->nullable();
            $table->integer('id_turno')->index('presentismo_tiene_turno_idx')->nullable();
            
            // Foreign
            $table->foreign('id_tipo_contrato', 'presentismo_tiene_tipo_contrato')
                ->references('id')
                ->on('tipo_contratos')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            
            $table->foreign('id_estado_contrato', 'presentismo_tiene_estado_contrato')
                ->references('id')
                ->on('estado_contratos')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            
            $table->foreign('id_turno', 'presentismo_tiene_turno')
                ->references('id')
                ->on('turnos')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
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
