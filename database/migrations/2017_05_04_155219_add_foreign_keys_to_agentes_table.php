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
			$table->foreign('id_contrato', 'agente_tiene_contrato')->references('id')->on('contratos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_dias_disponibles', 'agente_tiene_dias_diasponibles')->references('id')->on('dias_disponibles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_domicilio', 'agente_tiene_domicilio')->references('id')->on('domicilios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_estudio', 'agente_tiene_estudio')->references('id')->on('estudios')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
			$table->dropForeign('agente_tiene_contrato');
			$table->dropForeign('agente_tiene_dias_diasponibles');
			$table->dropForeign('agente_tiene_domicilio');
			$table->dropForeign('agente_tiene_estudio');
		});
	}

}
