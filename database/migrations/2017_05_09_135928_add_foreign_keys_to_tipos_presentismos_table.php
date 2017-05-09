<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTiposPresentismosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tipos_presentismos', function(Blueprint $table)
		{
			$table->foreign('id_padre', 'tiene_tipo_padre')->references('id')->on('tipos_presentismos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tipos_presentismos', function(Blueprint $table)
		{
			$table->dropForeign('tiene_tipo_padre');
		});
	}

}
