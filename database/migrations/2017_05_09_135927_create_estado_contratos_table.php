<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstadoContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('estado_contratos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('estado', 45);
			$table->string('descripcion', 100)->nullable();
			$table->integer('id_padre')->nullable()->index('estado_es_hijo_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('estado_contratos');
	}

}
