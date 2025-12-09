<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrackCantAgentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only run if estado_contratos has data (requires seed data)
        if (\Cat\Models\EstadoContrato::count() > 0) {
            \Cat\Modules\Agentes\Repositories\AgenteRepository::storeCountActivos();
        }
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
