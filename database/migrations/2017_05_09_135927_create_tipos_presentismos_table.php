<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTiposPresentismosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipos_presentismos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('codigo', 20)->index('tipo_index');
			$table->string('descripcion', 75);
			$table->integer('dias_permitidos');
			$table->integer('id_padre')->nullable()->index('tiene_tipo_padre_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tipos_presentismos');
	}

}
