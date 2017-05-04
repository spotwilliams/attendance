<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEstudiosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('estudios', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('institucion', 150);
			$table->string('carrera', 45);
			$table->enum('estado', array('En carrera','Abandonado','Recibido','Falta tesis'));
			$table->string('comentario', 200)->nullable();
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
		Schema::drop('estudios');
	}

}
