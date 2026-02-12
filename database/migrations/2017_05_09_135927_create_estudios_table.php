<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('estudios', function (Blueprint $table): void {
            $table->integer('id', true);
            $table->integer('id_agente')->index('estudio_es_de_agente_idx');
            $table->string('institucion', 150);
            $table->string('carrera', 45);
            $table->string('estado');
            $table->string('nivel');
            $table->string('comentario', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\Schema::drop('estudios');
    }
};
