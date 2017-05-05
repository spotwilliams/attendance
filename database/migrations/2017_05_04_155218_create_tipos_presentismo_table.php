<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTiposPresentismoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tipos_presentismo', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('tipo', 50)->index('tipo_index');
			$table->integer('dias_permitidos');
            $table->integer('id_padre')->nullable()->index('tipo_es_hijo_idx');
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
		Schema::drop('tipos_presentismo');
	}

}
