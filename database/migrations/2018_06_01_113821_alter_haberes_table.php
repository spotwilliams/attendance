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
        \Illuminate\Support\Facades\Schema::table('haberes', function (Blueprint $table): void {
            $table->integer('id_base')->nullable()->change();
            $table->integer('id_turno')->nullable()->change();
            $table->decimal('monto_facturado', 10)->nullable()->change();
            $table->decimal('monto_contrato', 10)->nullable()->change();
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
};
