<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAgentesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('agentes', function(Blueprint $table)
		{
			$table->foreign('id_area', 'agente_es_de_area')->references('id')->on('areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_base', 'agente_es_de_base')->references('id')->on('bases')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('agentes', function(Blueprint $table)
		{
			$table->dropForeign('agente_es_de_area');
			$table->dropForeign('agente_es_de_base');
		});
	}

}
