<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDiasDisponiblesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dias_disponibles', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_agente')->index('dias_es_de_agente_idx');
			$table->integer('id_tipo_presentismo')->index('dias_es_de_tipo_idx');
			$table->integer('cant_dias');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('dias_disponibles');
	}

}
