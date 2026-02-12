<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('comentarios', function (Blueprint $table): void {
            $table->integer('id', true);
            $table->string('comentario', 600)->nullable();
            $table->integer('id_user')->unsigned()->index('comentario_es_de_user_idx')->nullable();
            $table->integer('id_presentismo')->index('comentario_es_para_presentismo_idx');
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
        \Illuminate\Support\Facades\Schema::drop('comentarios');
    }
};
