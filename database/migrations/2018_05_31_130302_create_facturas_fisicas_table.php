<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasFisicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('facturas_fisicas', function (Blueprint $table) {
            
            $table->integer('id', true);
            $table->integer('id_agente')->index('factura_fisica_pertenece_agente_idx');
            $table->integer('id_periodo')->index('factura_fisica_pertenece_periodo_idx');
            $table->string('nro_factura');
            $table->timestamps();
            
        });
        \Illuminate\Support\Facades\Schema::table('facturas_fisicas', function (Blueprint $table) {
            
            $table->foreign('id_agente', 'factura_fisica_pertenece_agente')
                ->references('id')
                ->on('agentes')
                ->onUpdate('NO ACTION')
                ->onDelete('NO ACTION');
            
            $table->foreign('id_periodo', 'factura_fisica_pertenece_periodo')
                ->references('id')
                ->on('periodos')
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
        //
    }
}
