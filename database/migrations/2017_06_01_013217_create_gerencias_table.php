<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGerenciasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gerencias', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_padre')->nullable()->index('subgerencia_es_de_gerencia_idx');
			$table->string('nombre', 200)->index('nombre_gerencia');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gerencias');
	}

}
