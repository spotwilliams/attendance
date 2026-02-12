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
		\Illuminate\Support\Facades\Schema::create('horarios', function(Blueprint $table): void
		{
			$table->integer('id', true);
			$table->string('hora_entrada', 15);
			$table->string('hora_salida', 15);
			$table->boolean('eximido')->default(false);
			$table->boolean('rotativo')->default(false);
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
		\Illuminate\Support\Facades\Schema::drop('horarios');
	}
};
