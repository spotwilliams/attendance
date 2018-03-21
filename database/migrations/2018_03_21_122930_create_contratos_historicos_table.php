<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratosHistoricosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('contratos_historicos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_tipo_contrato')->index('contrato_historico_es_de_tipo_idx');
            $table->integer('id_estado_contrato')->index('contrato_historico_esta_en_estado_idx');
            $table->integer('id_agente')->index('contrato_historico_es_de_agente_idx');
            
            $table->date('fecha_ingreso')->default('1900-01-01');
            $table->date('fecha_ingreso_gobierno')->nullable();
            $table->date('fecha_fin')->default((new DateTime('2600-12-31'))->format('Y-m-d'));
            $table->date('fecha_estado_desde')->nullable();
            $table->date('fecha_estado_hasta')->nullable();
            
            
            $table->string('id_sial', 100)->nullable();
            $table->string('ficha', 100)->nullable();
            $table->string('tipo_inscripcion', 100)->nullable();
            $table->string('comentario', 400)->nullable();
            
            $table->decimal('monto', 10, 2)->default(16002);
            
            
        });
        \Illuminate\Support\Facades\Schema::table('contratos_historicos', function (Blueprint $table) {
            
            $table->foreign('id_agente', 'contrato_historico_es_de_agente')
                ->references('id')
                ->on('agentes')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            
            $table->foreign('id_tipo_contrato', 'contrato_historico_es_de_tipo')
                ->references('id')
                ->on('tipo_contratos')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            
            $table->foreign('id_estado_contrato', 'contrato_historico_esta_en_estado')
                ->references('id')
                ->on('estado_contratos')
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
        \Illuminate\Support\Facades\Schema::table('contratos', function (Blueprint $table) {
            $table->dropForeign('contrato_historico_es_de_agente');
            $table->dropForeign('contrato_historico_es_de_tipo');
            $table->dropForeign('contrato_historico_esta_en_estado');
            
        });
        
        \Illuminate\Support\Facades\Schema::drop('contratos_historicos');
        
    }
}
