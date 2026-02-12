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
        \Illuminate\Support\Facades\Schema::create('periodos', function (Blueprint $table): void {
            $table->integer('id', true);
            $table->date('fecha_comienzo')->index('comienzo_index');
            $table->date('fecha_fin')->index('fin_index');
            $table->integer('cant_dias');
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
        \Illuminate\Support\Facades\Schema::drop('periodos');
    }
};
