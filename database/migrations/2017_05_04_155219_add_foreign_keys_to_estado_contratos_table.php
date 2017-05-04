<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEstadoContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('estado_contratos', function(Blueprint $table)
		{
			$table->foreign('id_estado_padre', 'estado_es_hijo')->references('id')->on('estado_contratos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('estado_contratos', function(Blueprint $table)
		{
			$table->dropForeign('estado_es_hijo');
		});
	}

}
