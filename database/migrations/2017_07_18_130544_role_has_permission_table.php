<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RoleHasPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $config = config('laravel-permission.table_names');

        Schema::create($config['role_has_permissions'], function (Blueprint $table) use ($config) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
        
            $table->foreign('permission_id')
                ->references('id')
                ->on($config['permissions'])
                ->onDelete('cascade');
        
            $table->foreign('role_id')
                ->references('id')
                ->on($config['roles'])
                ->onDelete('cascade');
        
            $table->primary(['permission_id', 'role_id']);
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $config = config('laravel-permission.table_names');

        Schema::drop($config['role_has_permissions']);
    }
}
