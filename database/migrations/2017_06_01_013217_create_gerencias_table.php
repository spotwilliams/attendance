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
		\Illuminate\Support\Facades\Schema::create('gerencias', function(Blueprint $table): void
		{
			$table->integer('id', true);
			$table->integer('id_padre')->nullable()->index('subgerencia_es_de_gerencia_idx');
			$table->string('nombre', 200)->index('nombre_gerencia');
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
		\Illuminate\Support\Facades\Schema::drop('gerencias');
	}
};
