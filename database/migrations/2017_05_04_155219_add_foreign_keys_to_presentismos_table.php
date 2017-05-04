<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPresentismosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('presentismos', function(Blueprint $table)
		{
			$table->foreign('id_agente', 'presente_es_de_agente')->references('id')->on('agentes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_tipo_presentismo', 'presente_es_de_tipo')->references('id')->on('tipos_presentismo')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_jornada', 'presente_es_en_jornada')->references('id')->on('jornadas_laborables')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('presentismos', function(Blueprint $table)
		{
			$table->dropForeign('presente_es_de_agente');
			$table->dropForeign('presente_es_de_tipo');
			$table->dropForeign('presente_es_en_jornada');
		});
	}

}
