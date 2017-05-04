<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDiasDisponiblesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('dias_disponibles', function(Blueprint $table)
		{
			$table->foreign('id_tipo_presentismo', 'dias_es_de_tipo')->references('id')->on('tipos_presentismo')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('dias_disponibles', function(Blueprint $table)
		{
			$table->dropForeign('dias_es_de_tipo');
		});
	}

}
