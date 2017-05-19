<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstadoPeriodoTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_periodos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_base')->index('estado_periodo_es_de_base_idx');
            $table->integer('id_periodo')->index('estado_es_de_periodo_idx');
            $table->boolean('abierto');
            $table->timestamps();
            
            $table->unique(['id_base', 'id_periodo']);
        });
    }
    
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('estado_periodos');
    }
    
}
