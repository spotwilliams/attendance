<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToJornadasLaborablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('jornadas_laborables', function(Blueprint $table)
		{
			$table->foreign('id_periodo', 'jornada_pertenece_a_periodo')->references('id_periodo')->on('periodos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('jornadas_laborables', function(Blueprint $table)
		{
			$table->dropForeign('jornada_pertenece_a_periodo');
		});
	}

}
