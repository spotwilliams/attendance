<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RoleHasBasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = config('laravel-permission.table_names');
        
        Schema::create('base_roles', function (Blueprint $table) use ($config) {
            $table->integer('base_id');
            $table->integer('role_id')->unsigned();
            
            
            $table->foreign('role_id')
                ->references('id')
                ->on($config['roles'])
                ->onDelete('cascade');

            $table->foreign('base_id')
                ->references('id')
                ->on('bases')
                ->onDelete('cascade');
            
            $table->primary(['base_id', 'role_id']);
        });
        
    
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('base_roles');
        
    }
}
