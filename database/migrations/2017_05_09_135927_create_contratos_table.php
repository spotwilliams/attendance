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
        \Illuminate\Support\Facades\Schema::create('contratos', function (Blueprint $table): void {
            $table->integer('id', true);
            // Obligatorios
            $table->date('fecha_ingreso')->default('1900-01-01');
            $table->date('fecha_ingreso_gobierno')->nullable();
            
            // Relations
            $table->integer('id_tipo_contrato')->index('contrato_es_de_tipo_idx');
            $table->integer('id_estado_contrato')->index('contrato_esta_en_estado_idx');
            $table->integer('id_agente')->index('contrato_es_de_agente_idx');
            
            // Opcionales
            $table->string('id_sial', 100)->nullable();
            $table->string('ficha', 100)->nullable();
            $table->string('tipo_inscripcion', 100)->nullable();
            $table->decimal('monto', 10, 2)->default(14547);
            $table->date('fecha_baja')->nullable();
            $table->string('comentario_baja', 400)->nullable();
            
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
        \Illuminate\Support\Facades\Schema::drop('contratos');
    }
};
