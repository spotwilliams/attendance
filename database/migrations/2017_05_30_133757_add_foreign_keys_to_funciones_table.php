<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
		\Illuminate\Support\Facades\Schema::table('funciones', function(Blueprint $table): void
		{
			$table->foreign('id_padre', 'funcion_especifica_es_de_funcion')->references('id')->on('funciones')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		\Illuminate\Support\Facades\Schema::table('funciones', function(Blueprint $table): void
		{
			$table->dropForeign('funcion_especifica_es_de_funcion');
		});
	}
};
