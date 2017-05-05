<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePresentismosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('presentismos', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('id_agente')->index('jornada_es_de_agente_idx');
			$table->integer('id_jornada')->index('presente_es_en_jornada_idx');
			$table->integer('id_tipo_presentismo')->index('presente_es_de_tipo_idx');
            $table->integer('id_padre')->nullable()->index('tiene_tipo_padre_idx');
            
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
		Schema::drop('presentismos');
	}

}
