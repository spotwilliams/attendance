<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDomiciliosTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domicilios', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('id_agente')->index('domicilio_es_de_agente_idx');
            $table->string('calle', 100)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('departamento', 100)->nullable();
            $table->string('piso', 100)->nullable();
            $table->string('barrio', 100)->nullable();
            $table->string('provincia', 100)->nullable();
            $table->boolean('constituido')->default(true);
            $table->string('libre', 500)->nullable();
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
        Schema::drop('domicilios');
    }
    
}
