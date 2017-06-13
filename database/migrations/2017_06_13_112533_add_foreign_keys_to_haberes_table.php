<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToHaberesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('haberes', function(Blueprint $table)
		{
			$table->foreign('id_agente', 'haber_pertenece_agente')->references('id')->on('agentes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_periodo', 'haber_pertenece_periodo')->references('id')->on('periodos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('haberes', function(Blueprint $table)
		{
			$table->dropForeign('haber_pertenece_agente');
			$table->dropForeign('haber_pertenece_periodo');
		});
	}

}
