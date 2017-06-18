<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTiposPresentismosTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_presentismos', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('codigo', 50)->index('tipo_index');
            $table->string('descripcion', 100);
            $table->string('color', 10);
            $table->enum('aplica', ['LOCACION', 'SITUACION_REVISTA', 'TODOS', '']);
            $table->boolean('injustificado')->default(0);
            $table->boolean('corridos');
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
        Schema::drop('tipos_presentismos');
    }
    
}
