<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJornadasLaborablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jornadas_laborables', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->date('fecha')->index('fecha_index');
			$table->integer('id_periodo')->index('jornada_pertenece_a_periodo_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('jornadas_laborables');
	}

}
