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
		\Illuminate\Support\Facades\Schema::table('domicilios', function(Blueprint $table): void
		{
			$table->foreign('id_agente', 'domicilio_es_de_agente')->references('id')->on('agentes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		\Illuminate\Support\Facades\Schema::table('domicilios', function(Blueprint $table): void
		{
			$table->dropForeign('domicilio_es_de_agente');
		});
	}
};
