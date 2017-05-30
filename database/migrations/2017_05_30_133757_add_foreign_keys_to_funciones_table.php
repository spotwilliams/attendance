<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToFuncionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('funciones', function(Blueprint $table)
		{
			$table->foreign('id_funcion_padre', 'funcion_especifica_es_de_funcion')->references('id')->on('funciones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('funciones', function(Blueprint $table)
		{
			$table->dropForeign('funcion_especifica_es_de_funcion');
		});
	}

}
