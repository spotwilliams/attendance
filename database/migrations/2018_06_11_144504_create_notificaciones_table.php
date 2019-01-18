<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('notificaciones', function (Blueprint $table) {
        
            $table->integer('id', true);
            $table->integer('id_agente')->index('notificacion_tiene_agente_idx');
            $table->integer('id_periodo')->index('notificacion_tiene_periodo_idx');
            $table->enum('tipo', ['REGULAR', 'LIBRE']);
            $table->timestamps();
        
        });
    
        \Illuminate\Support\Facades\Schema::table('notificaciones', function (Blueprint $table) {
        
            $table->foreign('id_agente', 'notificacion_tiene_agente')
                ->references('id')
                ->on('agentes')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        
            $table->foreign('id_periodo', 'notificacion_tiene_periodo')
                ->references('id')
                ->on('periodos')
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
