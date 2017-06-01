<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToGerenciasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('gerencias', function(Blueprint $table)
		{
			$table->foreign('id_padre', 'subgerencia_es_de_gerencia')->references('id')->on('gerencias')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('gerencias', function(Blueprint $table)
		{
			$table->dropForeign('subgerencia_es_de_gerencia');
		});
	}

}
