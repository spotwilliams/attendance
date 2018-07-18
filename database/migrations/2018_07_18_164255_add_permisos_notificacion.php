<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermisosNotificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ps = [
            'name'        => 'Notificacion de facturacion',
            'comentarios' => 'Permite enviar mails a los agentes con datos para facturar',
        ];
    
        (new \Cat\Modules\Security\Models\Permission($ps))->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Cat\Modules\Security\Models\Permission::where('name', '=', 'Notificacion de facturacion')
            ->delete();
    }
}
