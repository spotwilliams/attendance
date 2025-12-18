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
        \Illuminate\Support\Facades\Schema::create('tipos_presentismos', function (Blueprint $table): void {
            $table->integer('id', true);
            $table->string('codigo', 50)->index('tipo_index');
            $table->string('descripcion', 100);
            $table->string('color', 10);
            $table->string('color_letra', 10)->default('#333');
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
        \Illuminate\Support\Facades\Schema::drop('tipos_presentismos');
    }
};
