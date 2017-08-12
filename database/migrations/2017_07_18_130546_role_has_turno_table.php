<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RoleHasTurnoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = config('laravel-permission.table_names');
        
        Schema::create('turno_roles', function (Blueprint $table) use ($config) {
            $table->integer('turno_id');
            $table->integer('role_id')->unsigned();
            
            
            $table->foreign('role_id')
                ->references('id')
                ->on($config['roles'])
                ->onDelete('cascade');

            $table->foreign('turno_id')
                ->references('id')
                ->on('turnos')
                ->onDelete('cascade');
            
            $table->primary(['turno_id', 'role_id']);
        });
        
    
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('turno_roles');
        
    }
}
