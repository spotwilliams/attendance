<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgentesTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agentes', function (Blueprint $table) {
            // Obligatorios
            $table->integer('id', true);
            $table->string('nombre', 60)->index('nombre_index');
            $table->string('apellido', 60)->index('apellido_index');
            $table->string('dni', 60)->unique('dni_index');
            $table->date('fecha_nacimiento');
            $table->string('email', 100);
            $table->string('cuit', 45)->unique('cuit_index');
    
            // Nullables
            $table->enum('estado_civil', ['CASADO', 'SOLTERO', 'DIVORCIADO', 'VIUDO'])->nullable();
            $table->string('celular')->nullable();
            
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
        Schema::drop('agentes');
    }
    
}
