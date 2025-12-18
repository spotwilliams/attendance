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
		\Illuminate\Support\Facades\Schema::table('estado_contratos', function(Blueprint $table): void
		{
			$table->foreign('id_padre', 'estado_es_hijo')->references('id')->on('estado_contratos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		\Illuminate\Support\Facades\Schema::table('estado_contratos', function(Blueprint $table): void
		{
			$table->dropForeign('estado_es_hijo');
		});
	}
};
