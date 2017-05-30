<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToOperativosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('operativos', function(Blueprint $table)
		{
			$table->foreign('id_agente', 'operativo_pertenece_agente')->references('id')->on('agentes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_area', 'operativo_pertenece_area')->references('id')->on('areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_base', 'operativo_pertenece_base')->references('id')->on('bases')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_funcion', 'operativo_tiene_funcion')->references('id')->on('funciones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_horario', 'operativo_tiene_horario')->references('id')->on('horarios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_turno', 'operativo_tiene_turno')->references('id')->on('turnos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('operativos', function(Blueprint $table)
		{
			$table->dropForeign('operativo_pertenece_agente');
			$table->dropForeign('operativo_pertenece_area');
			$table->dropForeign('operativo_pertenece_base');
			$table->dropForeign('operativo_tiene_funcion');
			$table->dropForeign('operativo_tiene_horario');
			$table->dropForeign('operativo_tiene_turno');
		});
	}

}
