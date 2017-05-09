<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAgentesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('agentes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('nombre', 60)->index('nombre_index');
			$table->string('apellido', 60)->index('apellido_index');
			$table->integer('dni')->index('dni_index');
			$table->date('fecha_nacimiento');
			$table->string('cuit', 45)->index('cuit_index');
			$table->integer('id_base')->index('agente_pertenece_base_idx');
			$table->integer('id_area')->index('agente_es_de_area_idx');
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
		Schema::drop('agentes');
	}

}
