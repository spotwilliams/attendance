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
		\Illuminate\Support\Facades\Schema::table('gerencias', function(Blueprint $table): void
		{
			$table->foreign('id_padre', 'subgerencia_es_de_gerencia')->references('id')->on('gerencias')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		\Illuminate\Support\Facades\Schema::table('gerencias', function(Blueprint $table): void
		{
			$table->dropForeign('subgerencia_es_de_gerencia');
		});
	}
};
