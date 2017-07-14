<?php
namespace Cat\Database\Seeds\Agentes;

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
            'Dirección',
            'Actas',
//            'Adm. Evaluación y desarrollo del Personal',
            'Alcoholemia',
            'Autos Abandonados',
            'Cajas y Convenios',
            'CEF',
            'Choferes',
            'Combis',
            'Compras',
            'Compras y Presupuesto',
            'Comunicaciones',
//            'Contratos y Facturación',
            'DCER',
            'Desarrollo Humano',
            'Educación Vial',
            'Estadistica',
            'Gruas',
            'Incorporación y Formación de Ag. De Tránsito',
            'Legales',
            'Mantenimiento',
//            'Medicina Laboral y ART',
            'Mesa de Entrada',
            'Mesa de Entrada Seguridad Vial',
            'Observatorio Vial',
            'Operadores',
            'Operativa',
            'Pañol',
            'Patrimonio',
            'Monitoreo',
            'Planeamiento',
            'Playa de Acarreo',
//            'Presentismo y Legajos del Personal',
            'Recursos Materiales',
            'Rel. Institucionales',
            'Sistemas',
            'Taller',
            'Uniformes',
            'Upe',
            'Personal'
        ];
        
        foreach ($areas as $a) {
            Area::create(
                [
                    'nombre' => $a,
                ]
            );
        }
        
    }
}
