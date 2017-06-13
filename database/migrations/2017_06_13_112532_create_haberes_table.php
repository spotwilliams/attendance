<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHaberesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('haberes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_agente')->index('pertenece_agente_idx');
			$table->integer('id_periodo')->index('pertenece_periodo_idx');
			$table->decimal('monto_facturado', 10);
			$table->decimal('monto_contrato', 10);
			$table->unique(['id_agente','id_periodo'], 'un_haber_por_periodo');
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
		Schema::drop('haberes');
	}

}
