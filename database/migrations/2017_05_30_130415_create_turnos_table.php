<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTurnosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('turnos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('codigo', 10)->index('codigo');
			$table->string('descripcion', 60)->nullable();
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
		Schema::drop('turnos');
	}

}
