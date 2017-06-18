<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEstadoPeriodoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('estado_periodos', function(Blueprint $table)
		{
			$table->foreign('id_periodo', 'estado_es_de_periodo')->references('id')->on('periodos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_base', 'estado_periodo_es_de_base')->references('id')->on('bases')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_turno', 'estado_periodo_es_de_turno')->references('id')->on('turnos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('estado_periodos', function(Blueprint $table)
		{
			$table->dropForeign('estado_es_de_periodo');
			$table->dropForeign('estado_periodo_es_de_base');
		});
	}

}
