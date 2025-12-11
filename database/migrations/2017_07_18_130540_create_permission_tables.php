<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        \Illuminate\Support\Facades\Schema::create($tableNames['permissions'], function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name')->default('web'); // For MySQL 8.0 use string('guard_name', 125);
            $table->string('comentarios', 500)->nullable();
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        \Illuminate\Support\Facades\Schema::create($tableNames['roles'], function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name')->default('web'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        \Illuminate\Support\Facades\Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames): void {
            $table->unsignedBigInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
                'model_has_permissions_permission_model_type_primary');
        });

        \Illuminate\Support\Facades\Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames): void {
            $table->unsignedBigInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],
                'model_has_roles_role_model_type_primary');
        });

        \Illuminate\Support\Facades\Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames): void {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        resolve('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $config = config('laravel-permission.table_names');

        \Illuminate\Support\Facades\Schema::drop($config['role_has_permissions']);
        \Illuminate\Support\Facades\Schema::drop($config['user_has_roles']);
        \Illuminate\Support\Facades\Schema::drop($config['user_has_permissions']);
        \Illuminate\Support\Facades\Schema::drop($config['roles']);
        \Illuminate\Support\Facades\Schema::drop($config['permissions']);
        \Illuminate\Support\Facades\Schema::drop('base_roles');
    }
};
