<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOperativosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('operativos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_agente')->unique('operativo_es_de_agente_idx');
			$table->integer('id_base')->index('operativo_pertenece_base_idx');
			$table->integer('id_gerencia')->nullable()->index('operativo_pertenece_area_idx');
			$table->integer('id_turno')->index('operativo_tiene_turno_idx');
			$table->integer('id_horario')->index('operativo_tiene_horario_idx');
			$table->integer('id_funcion')->index('operativo_tiene_funcion_idx');
			$table->integer('id_area')->nullable()->index('operativo_pertenece_area_idx1');
			$table->integer('id_cargo')->nullable()->index('operativo_tiene_cargo_idx');
			$table->string('funcion_especifica', 200)->nullable();
            $table->timestamps();
            $table->softDeletes();
            
        });
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('operativos');
	}

}
