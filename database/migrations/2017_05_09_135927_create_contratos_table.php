<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contratos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_tipo_contrato')->index('contrato_es_de_tipo_idx');
			$table->integer('id_estado_contrato')->index('contrato_esta_en_estado_idx');
			$table->integer('id_agente')->index('contrato_es_de_agente_idx');
			$table->date('fecha_firma');
			$table->date('fecha_comienzo');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contratos');
	}

}
