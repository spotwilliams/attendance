<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstudiosTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_agente')->index('estudio_es_de_agente_idx');
            $table->string('institucion', 150);
            $table->string('carrera', 45);
            $table->enum('estado', array('CURSANDO', 'ABANDONADO', 'RECIBIDO'));
            $table->enum('nivel', array(
                'SECUNDARIO',
                'TERCIARIO',
                'UNIVERSITARIO',
                'POSGRADO',
                'MASTER',
                'DOCTORADO',
                'OTRO',
            ));
            $table->string('comentario', 200)->nullable();
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
        Schema::drop('estudios');
    }
    
}
