<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsToContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->date('fecha_estado_desde')->nullable();
            $table->date('fecha_estado_hasta')->nullable();
            $table->renameColumn('comentario_baja', 'comentario');
    
            $table->renameColumn('fecha_baja', 'fecha_fin');
    
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
