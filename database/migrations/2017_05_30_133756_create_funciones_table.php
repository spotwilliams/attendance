<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFuncionesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('funciones', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_funcion_padre')->nullable()->index('funcion_especifica_es_de_funcion_idx');
			$table->string('nombre', 200);
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
		Schema::drop('funciones');
	}

}
