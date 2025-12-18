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
        \Illuminate\Support\Facades\Schema::table('dias_permitidos', function (Blueprint $table): void {
            $table->foreign('id_tipo_presentismo',
                'es_de_tipo')->references('id')->on('tipos_presentismos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\Schema::table('dias_permitidos', function (Blueprint $table): void {
            $table->dropForeign('es_de_tipo');
        });
    }
};
