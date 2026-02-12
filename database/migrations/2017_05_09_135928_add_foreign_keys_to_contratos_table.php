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
		\Illuminate\Support\Facades\Schema::table('contratos', function(Blueprint $table): void
		{
			$table->foreign('id_agente', 'contrato_es_de_agente')->references('id')->on('agentes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_tipo_contrato', 'contrato_es_de_tipo')->references('id')->on('tipo_contratos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_estado_contrato', 'contrato_esta_en_estado')->references('id')->on('estado_contratos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		\Illuminate\Support\Facades\Schema::table('contratos', function(Blueprint $table): void
		{
			$table->dropForeign('contrato_es_de_agente');
			$table->dropForeign('contrato_es_de_tipo');
			$table->dropForeign('contrato_esta_en_estado');
		});
	}
};
