<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOperativosHistoricosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('operativos_historicos', function(Blueprint $table)
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
		Schema::drop('operativos_historicos');
	}

}
