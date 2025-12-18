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
		\Illuminate\Support\Facades\Schema::create('operativos_historicos', function(Blueprint $table): void
		{
			$table->integer('id', true);
			$table->integer('id_agente')->nullable();
			$table->integer('id_base')->nullable();
			$table->integer('id_gerencia')->nullable();
			$table->integer('id_turno')->nullable();
			$table->integer('id_horario')->nullable();
			$table->integer('id_funcion')->nullable();
			$table->integer('id_area')->nullable();
			$table->integer('id_cargo')->nullable();
			$table->integer('id_user')->nullable();
		});
	}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		\Illuminate\Support\Facades\Schema::drop('operativos_historicos');
	}
};
