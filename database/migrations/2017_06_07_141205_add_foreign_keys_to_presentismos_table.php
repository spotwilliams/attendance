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
		\Illuminate\Support\Facades\Schema::table('presentismos', function(Blueprint $table): void
		{
			$table->foreign('id_agente', 'presente_es_de_agente')->references('id')->on('agentes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_periodo', 'presente_es_de_periodo')->references('id')->on('periodos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_tipo_presentismo', 'presente_es_de_tipo')->references('id')->on('tipos_presentismos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		\Illuminate\Support\Facades\Schema::table('presentismos', function(Blueprint $table): void
		{
			$table->dropForeign('presente_es_de_agente');
			$table->dropForeign('presente_es_de_periodo');
			$table->dropForeign('presente_es_de_tipo');
		});
	}
};
