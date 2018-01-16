<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToComentariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->foreign('id_user', 'comentario_es_de_user')
                ->references('id')
                ->on('users')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            
            $table->foreign('id_presentismo', 'comentario_es_para_presentismo')
                ->references('id')
                ->on('presentismos')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comentarios', function (Blueprint $table) {
            $table->dropForeign('comentario_es_de_user');
            $table->dropForeign('comentario_es_para_conpceto');
        });
        
    }
}
