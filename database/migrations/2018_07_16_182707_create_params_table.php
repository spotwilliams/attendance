<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('params', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('param', 240);
            $table->string('descripcion', 240);
            $table->string('valor', 240);
            $table->timestamps();
        });
        
        \Cat\Models\Param::create([
            'param'       => 'fecha_cierre_periodo',
            'descripcion' => 'Fecha de cierre del periodo actual',
            'valor'       => '20',
        ]);
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\Schema::drop('params');
    }
};
