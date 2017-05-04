<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContratosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contratos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->enum('tipo_contrato', array('Planta','Locacion','Temporal'));
			$table->date('fecha_firma');
			$table->date('fecha_comienzo');
			$table->integer('id_estado_contrato')->index('contrato_esta_en_estado_idx');
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
		Schema::drop('contratos');
	}

}
