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
		\Illuminate\Support\Facades\Schema::create('tipo_contratos', function(Blueprint $table): void
		{
			$table->integer('id', true);
			$table->string('codigo', 45)->index('codigo_idx');
			$table->string('descripcion', 45);
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
		\Illuminate\Support\Facades\Schema::drop('tipo_contratos');
	}
};
