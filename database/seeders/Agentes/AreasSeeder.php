<?php
namespace Database\Seeders\Agentes;

use Cat\Models\Area;
use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            'Recursos Humanos', 'Contabilidad', 'Finanzas', 'Logística',
            'Sistemas', 'Legales', 'Compras', 'Mantenimiento',
            'Comunicaciones', 'Estadística', 'Operaciones', 'Capacitación',
            'Mesa de Entrada', 'Patrimonio', 'Planeamiento', 'Monitoreo',
            'Educación', 'Seguridad', 'Administración', 'Archivo',
            'Auditoría', 'Calidad', 'Transporte', 'Almacén',
            'Relaciones Institucionales', 'Desarrollo', 'Coordinación',
            'Infraestructura', 'Presupuesto', 'Atención al Público',
            'Control Interno', 'Despacho', 'Gestión Documental',
            'Tecnología', 'Medio Ambiente', 'Suministros', 'Dirección',
        ];

        foreach ($areas as $a) {
            Area::create(['nombre' => $a]);
        }
    }
}
