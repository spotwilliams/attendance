<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('turnos_historicos', function (Blueprint $table): void {
            $table->integer('id', true);
            $table->integer('id_operativo')->index('turno_historico_pertenece_operativo_idx');
            $table->integer('id_turno')->index('turno_historico_tiene_turno_idx');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->default((new DateTime('2600-12-31'))->format('Y-m-d'));
            
            
            // Foreign
            $table->foreign('id_operativo', 'turno_historico_pertenece_operativo')
                ->references('id')
                ->on('operativos')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            
            $table->foreign('id_turno', 'turno_historico_tiene_turno')
                ->references('id')
                ->on('turnos')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            
        });
        
        \Illuminate\Support\Facades\DB::insert('INSERT INTO turnos_historicos (id_operativo, id_turno, fecha_inicio)
                                                      SELECT
                                                        id AS id_operativo,
                                                        id_turno,
                                                        created_at
                                                      FROM operativos;
                                                ');
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\Schema::drop('turnos_historicos');
    }
};
