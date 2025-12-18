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
        $config = config('laravel-permission.table_names');
        
        \Illuminate\Support\Facades\Schema::create('turno_roles', function (Blueprint $table) use ($config): void {
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
        \Illuminate\Support\Facades\Schema::drop('turno_roles');
        
    }
};
