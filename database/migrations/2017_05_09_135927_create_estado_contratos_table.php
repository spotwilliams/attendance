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
        \Illuminate\Support\Facades\Schema::create('estado_contratos', function (Blueprint $table): void {
            $table->integer('id', true);
            $table->string('estado', 45);
            $table->string('descripcion', 100)->nullable();
            $table->integer('id_padre')->nullable()->index('estado_es_hijo_idx');
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
        \Illuminate\Support\Facades\Schema::drop('estado_contratos');
    }
};
