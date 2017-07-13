<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePresentismosTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentismos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_agente');
            $table->integer('id_tipo_presentismo')->index('presente_es_de_tipo_idx');
            $table->integer('id_periodo')->index('presente_es_de_periodo_idx');
            $table->date('fecha')->index('fecha_laboral');
            $table->boolean('injustificado')->default(false);
            $table->boolean('tardanza_calculada')->default(false);
            $table->string('comentario', 400)->nullable();
            $table->unique(['id_agente', 'fecha', 'id_periodo']);
            $table->timestamps();
        });
    }
    
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('presentismos');
    }
    
}
