<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHorariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('horarios', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('hora_entrada', 15);
			$table->string('hora_salida', 15);
			$table->boolean('eximido')->default(false);
			$table->boolean('rotativo')->default(false);
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
		Schema::drop('horarios');
	}

}
