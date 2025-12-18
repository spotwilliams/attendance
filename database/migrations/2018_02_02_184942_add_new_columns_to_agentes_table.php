<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agentes', function (Blueprint $table): void {
            $table->string('avatar', 450)->default('default.jpg');
            $table->text('observacion', 950)->nullable();
            $table->string('profesion', 450)->nullable();
            $table->string('email_gobierno', 250)->nullable();
            $table->renameColumn('telefono', 'telefono_particular');
            $table->string('telefono_casa', 100)->nullable();
            $table->string('telefono_ht', 100)->nullable();

        });
        
        \Cat\Models\Agente::whereNull('avatar')
            ->update(['avatar' => 'default.jpg']);
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
