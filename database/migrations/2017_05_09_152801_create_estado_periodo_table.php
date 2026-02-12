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
        \Illuminate\Support\Facades\Schema::create('estado_periodos', function (Blueprint $table): void {
            $table->integer('id', true);
            $table->integer('id_base')->index('estado_periodo_es_de_base_idx');
            $table->integer('id_periodo')->index('estado_es_de_periodo_idx');
            $table->integer('id_turno')->index('estado_es_de_turno_idx');
            $table->boolean('abierto');
            $table->timestamps();
            
            $table->unique(['id_base', 'id_periodo', 'id_turno']);
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\Schema::drop('estado_periodos');
    }
};
