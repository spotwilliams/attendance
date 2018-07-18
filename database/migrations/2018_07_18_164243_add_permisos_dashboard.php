<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermisosDashboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $ps = [
            'name'        => 'Datos estadisticos inicio',
            'comentarios' => 'Permite ver los datos estadisticos generados al inicio',
        ];
        
        (new \Cat\Modules\Security\Models\Permission($ps))->save();
//        \Cat\Modules\Security\Models\Permission::create($ps);
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Cat\Modules\Security\Models\Permission::where('name', '=', 'Datos estadisticos inicio')
            ->delete();
    }
}
