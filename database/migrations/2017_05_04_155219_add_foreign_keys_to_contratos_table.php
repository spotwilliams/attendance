<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contratos', function(Blueprint $table)
		{
			$table->foreign('id_estado_contrato', 'contrato_esta_en_estado')->references('id')->on('estado_contratos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contratos', function(Blueprint $table)
		{
			$table->dropForeign('contrato_esta_en_estado');
		});
	}

}
