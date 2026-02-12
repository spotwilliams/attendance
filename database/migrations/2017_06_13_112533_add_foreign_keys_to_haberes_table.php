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
		\Illuminate\Support\Facades\Schema::table('haberes', function(Blueprint $table): void
		{
			$table->foreign('id_agente', 'haber_pertenece_agente')->references('id')->on('agentes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_periodo', 'haber_pertenece_periodo')->references('id')->on('periodos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_base', 'haber_pertenece_base')->references('id')->on('bases')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('id_turno', 'haber_pertenece_turno')->references('id')->on('turnos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		\Illuminate\Support\Facades\Schema::table('haberes', function(Blueprint $table): void
		{
			$table->dropForeign('haber_pertenece_agente');
			$table->dropForeign('haber_pertenece_periodo');
			$table->dropForeign('haber_pertenece_base');
			$table->dropForeign('haber_pertenece_turno');
		});
	}
};
