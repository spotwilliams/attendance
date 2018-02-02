<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToAgentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agentes', function (Blueprint $table) {
            $table->string('photo', 450)->nullable();
            $table->text('observacion', 950)->nullable();
            $table->string('profesion', 450)->nullable();
            $table->string('email_gobierno', 250)->nullable();
            $table->renameColumn('telefono', 'telefono_particular');
            $table->string('telefono_casa', 100)->nullable();
            $table->string('telefono_ht', 100)->nullable();
            
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
