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
        \Illuminate\Support\Facades\Schema::create('dias_permitidos', function (Blueprint $table): void {
            $table->integer('id', true);
            $table->integer('cant_semanal');
            $table->integer('cant_fin_semana');
            $table->integer('id_tipo_presentismo')->index('es_de_tipo_idx');
            $table->enum('mes_ingreso', array(
                'JULY',
                'AUGUST',
                'SEPTEMBER',
                'OCTOBER',
                'NOVEMBER',
                'DECEMBER',
            ));
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
        \Illuminate\Support\Facades\Schema::drop('dias_permitidos');
    }
};
