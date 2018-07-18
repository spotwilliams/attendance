<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermisosFacturacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Cat\Modules\Security\Models\Permission::where('name', '=', 'Calcular haberes')
            ->delete();
    
        $ps = [
            'name'        => 'Registro facturacion',
            'comentarios' => 'Permite registrar para un periodo a quienes se les facturo',
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
        \Cat\Modules\Security\Models\Permission::where('name', '=', 'Registro facturacion')
            ->delete();
    }
}
