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
            $table->string('dni', 60)->index('dni_index')->nullable();
            $table->date('fecha_nacimiento')->default('1900-01-01');
            $table->string('email', 100);
            $table->string('sexo', 10)->nullable();
            $table->string('telefono', 100);
            $table->string('cuit', 45)->unique('cuit_index');
            
            // Nullables
            $table->string('estado_civil')->nullable();
            
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
        Schema::drop('agentes');
    }
    
}
