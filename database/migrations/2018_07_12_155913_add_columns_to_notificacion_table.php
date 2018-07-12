<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToNotificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::table('notificaciones', function (Blueprint $table) {
            $table->string('fecha_factura', 10)->nullable();
            $table->string('fecha_pago', 10)->nullable();
            $table->string('mensaje', 400)->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
