<?php
namespace Database\Seeders\Agentes;

use Cat\Models\Funcion;
use Illuminate\Database\Seeder;

class Funciones extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//        $funciones = [
//            [
//                'id'       => 1,
//                'id_padre' => null,
//                'nombre'   => 'ADMINISTRATIVO',
//            ],
//            [
//                'id'       => 2,
//                'id_padre' => null,
//                'nombre'   => 'APOYO OPERATIVO',
//            ],
//            [
//                'id'       => 3,
//                'id_padre' => null,
//                'nombre'   => 'OPERATIVO',
//            ],
//            [
//                'id'       => 4,
//                'id_padre' => null,
//                'nombre'   => 'PERSONAL SUPERIOR',
//            ],
//
//            // Hijos de 1 - Administrativo
//            ['id_padre' => 1, 'nombre' => 'ACTAS',],
//            ['id_padre' => 1, 'nombre' => 'ASUNTOS LEGALES',],
//            ['id_padre' => 1, 'nombre' => 'AUTOS ABANDONADOS',],
//            ['id_padre' => 1, 'nombre' => 'CAPACITACION',],
//            ['id_padre' => 1, 'nombre' => 'CAPACITACION COORDINADOR',],
//            ['id_padre' => 1, 'nombre' => 'CHOFER',],
//            ['id_padre' => 1, 'nombre' => 'CHOFER GERENCIA OPERATIVA',],
//            ['id_padre' => 1, 'nombre' => 'COMPRAS',],
//            ['id_padre' => 1, 'nombre' => 'COMUNICACIONES Y ROPERIA',],
//            ['id_padre' => 1, 'nombre' => 'COMUNICACIONES Y ROPERIA COORDINADOR',],
//            ['id_padre' => 1, 'nombre' => 'COORDINADOR ACTAS',],
//            ['id_padre' => 1, 'nombre' => 'COORDINADOR ALCOHOLEMIA TURNO NOCHE',],
//            ['id_padre' => 1, 'nombre' => 'COORDINADOR DE AUTOS ABANDONADOS',],
//            ['id_padre' => 1, 'nombre' => 'COORDINADOR GENERAL ALCOHOLEMIA',],
//            ['id_padre' => 1, 'nombre' => 'COORDINADOR GRAL CUCC',],
//            ['id_padre' => 1, 'nombre' => 'COORDINADOR TURNO MAÑANA ALCO',],
//            ['id_padre' => 1, 'nombre' => 'DEPARTAMENTO DE PLANEAMIENTO',],
//            ['id_padre' => 1, 'nombre' => 'DEPARTAMENTO DE PLANEAMIENTO COORDINADOR',],
//            ['id_padre' => 1, 'nombre' => 'DESARROLLO HUMANO',],
//            ['id_padre' => 1, 'nombre' => 'DESARROLLO HUMANO COORDINADOR',],
//            ['id_padre' => 1, 'nombre' => 'ESTADISTICAS',],
//            ['id_padre' => 1, 'nombre' => 'ESTADISTICAS COORDINADOR',],
//            ['id_padre' => 1, 'nombre' => 'FISCALIZADORES',],
//            ['id_padre' => 1, 'nombre' => 'GREMIO',],
//            ['id_padre' => 1, 'nombre' => 'INFANTE',],
//            ['id_padre' => 1, 'nombre' => 'LOGISTICA',],
//            ['id_padre' => 1, 'nombre' => 'MANTENIMIENTO',],
//            ['id_padre' => 1, 'nombre' => 'MANTENIMIENTO COORDINADOR',],
//            ['id_padre' => 1, 'nombre' => 'MANTENIMIENTO SUPERVISOR',],
//            ['id_padre' => 1, 'nombre' => 'MESA DE ENTRADA',],
//            ['id_padre' => 1, 'nombre' => 'MESA DE ENTRADA COORDINADOR',],
//            ['id_padre' => 1, 'nombre' => 'OPERADORES',],
//            ['id_padre' => 1, 'nombre' => 'OPERATIVO',],
//            ['id_padre' => 1, 'nombre' => 'PAÑOL',],
//            ['id_padre' => 1, 'nombre' => 'PAÑOL COORDINADOR',],
//            ['id_padre' => 1, 'nombre' => 'PAÑOL SUPERVISOR',],
//            ['id_padre' => 1, 'nombre' => 'PERSONAL',],
//            ['id_padre' => 1, 'nombre' => 'RECURSOS MATERIALES',],
//            ['id_padre' => 1, 'nombre' => 'RELACIONES INSTITUCIONALES',],
//            ['id_padre' => 1, 'nombre' => 'SEGURIDAD VIAL',],
//            ['id_padre' => 1, 'nombre' => 'SISTEMAS',],
//            ['id_padre' => 1, 'nombre' => 'SUPERVISOR ACTAS',],
//            ['id_padre' => 1, 'nombre' => 'SUPERVISOR OPERADORES',],
//            ['id_padre' => 1, 'nombre' => 'TALLER BALCARCE',],
//            ['id_padre' => 1, 'nombre' => 'TALLER BALCARCE COORDINADOR',],
//
//            // Hijos de 2 - Apoyo Operativo
//
//            ['id_padre' => 2, 'nombre' => 'AGENTE COMBIS',],
//            ['id_padre' => 2, 'nombre' => 'AGENTE PLAYA ACARREO',],
//            ['id_padre' => 2, 'nombre' => 'COORDINADOR OPERATIVO DCER',],
//            ['id_padre' => 2, 'nombre' => 'COORDINADOR PLAYAS DE ACARREO',],
//            ['id_padre' => 2, 'nombre' => 'INFANTE',],
//            ['id_padre' => 2, 'nombre' => 'INFANTE/ALCOHOLEMIA',],
//            ['id_padre' => 2, 'nombre' => 'INFANTE-A',],
//            ['id_padre' => 2, 'nombre' => 'SUPERVISOR INFANTES',],
//
//            // Hijos de 3 -  Operativo
//            ['id_padre' => 3, 'nombre' => 'ACTAS',],
//            ['id_padre' => 3, 'nombre' => 'AGENTE COMBIS',],
//            ['id_padre' => 3, 'nombre' => 'CHOFER',],
//            ['id_padre' => 3, 'nombre' => 'CHOFER SUPERVISOR',],
//            ['id_padre' => 3, 'nombre' => 'CHOFER/DIRECTOR',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR BRD FIN DE SEMANA',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR BRD GARAY',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR BRD SARMIENTO',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR CHOFER CHACABUCO',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR CHOFER FIN DE SEMANA',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR CHOFER FIN DE SEMANA DIURNO',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR CHOFER FIN DE SEMANA NOCHE',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR CHOFER LAS HERAS',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR CHOFER PIEDRAS',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR CHOFER SEF',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR FIN DE SEMANA DIURNO',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR FIN DE SEMANA NOCTURNO ALCO',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR GENERAL CHOFERES',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR GRAL CUCC',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR INTERMEDIO TARDE',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR TURNO MAÑANA',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR TURNO NOCHE',],
//            ['id_padre' => 3, 'nombre' => 'COORDINADOR TURNO TARDE',],
//            ['id_padre' => 3, 'nombre' => 'DEPARTAMENTO DE PLANEAMIENTO',],
//            ['id_padre' => 3, 'nombre' => 'ESTADISTICAS',],
//            ['id_padre' => 3, 'nombre' => 'GREMIO',],
//            ['id_padre' => 3, 'nombre' => 'INFANTE',],
//            ['id_padre' => 3, 'nombre' => 'INFANTE/ACOHOLEMIA',],
//            ['id_padre' => 3, 'nombre' => 'INFANTE/ALCOHOLEMIA',],
//            ['id_padre' => 3, 'nombre' => 'INFANTE-A',],
//            ['id_padre' => 3, 'nombre' => 'JEFE DE BASE',],
//            ['id_padre' => 3, 'nombre' => 'JEFE DE BASE GRUAS BRD',],
//            ['id_padre' => 3, 'nombre' => 'MOTOS',],
//            ['id_padre' => 3, 'nombre' => 'MOTOS/ALCOHOLEMIA',],
//            ['id_padre' => 3, 'nombre' => 'OPERADORES',],
//            ['id_padre' => 3, 'nombre' => 'OPERATIVO',],
//            ['id_padre' => 3, 'nombre' => 'OPERATIVO/ALCOHOLEMIA',],
//            ['id_padre' => 3, 'nombre' => 'PAÑOL',],
//            ['id_padre' => 3, 'nombre' => 'SEGURIDAD VIAL',],
//            ['id_padre' => 3, 'nombre' => 'SUPERVISOR',],
//            ['id_padre' => 3, 'nombre' => 'SUPERVISOR AGENTES',],
//            ['id_padre' => 3, 'nombre' => 'SUPERVISOR INFANTES',],
//            ['id_padre' => 3, 'nombre' => 'SUPERVISOR INFANTES/ALCOHOLEMIA',],
//            ['id_padre' => 3, 'nombre' => 'SUPERVISOR MOTOS',],
//            ['id_padre' => 3, 'nombre' => 'SUPERVISOR MOTOS E INFANTES',],
//            ['id_padre' => 3, 'nombre' => 'SUPERVISOR OPERADORES',],
//            ['id_padre' => 3, 'nombre' => 'TALLER BALCARCE',],
//
//            // Hijos de 4 -  Personal superior
//
//            ['id_padre' => 4, 'nombre' => 'OPERATIVO',],
//            ['id_padre' => 4, 'nombre' => 'PERSONAL',],
//            ['id_padre' => 4, 'nombre' => 'RECURSOS MATERIALES',],
//            ['id_padre' => 4, 'nombre' => 'SEGURIDAD VIAL',],
//            ['id_padre' => 4, 'nombre' => 'SUBGERENTE OPERATIVO BASE CHACABUCO',],
//            ['id_padre' => 4, 'nombre' => 'SUBGERENTE OPERATIVO BASE LAS HERAS',],
//            ['id_padre' => 4, 'nombre' => 'SUBGERENTE OPERATIVO BASE PIEDRAS',],
//
//        ];
        
        $funciones = [
            ['id' => 1, 'id_padre' => null, 'nombre' => 'Administrativo',],
            ['id' => 2, 'id_padre' => null, 'nombre' => 'Jerárquico',],
            ['id' => 3, 'id_padre' => null, 'nombre' => 'Operativo',],
            
            
//            ['id' => null, 'id_padre' => 1, 'nombre' => 'Administrativo'],
//            ['id' => null, 'id_padre' => 1, 'nombre' => 'Operador'],
//            ['id' => null, 'id_padre' => 1, 'nombre' => 'Apoyo Operativo'],
//            ['id' => null, 'id_padre' => 1, 'nombre' => 'Actas'],
//            ['id' => null, 'id_padre' => 1, 'nombre' => 'Coordinador'],
//
//
//            ['id' => null, 'id_padre' => 2, 'nombre' => 'Gerente'],
//            ['id' => null, 'id_padre' => 2, 'nombre' => 'Subgerente'],
//            ['id' => null, 'id_padre' => 2, 'nombre' => 'Apoyo Operativo'],
//            ['id' => null, 'id_padre' => 2, 'nombre' => 'Jefe de Base'],
//            ['id' => null, 'id_padre' => 2, 'nombre' => 'Abogada'],
//
//            ['id' => null, 'id_padre' => 3, 'nombre' => 'Agente de Tránsito'],
//            ['id' => null, 'id_padre' => 3, 'nombre' => 'Agente de Tránsito/Motos'],
//            ['id' => null, 'id_padre' => 3, 'nombre' => 'Agente de Tránsito/Alcoholemia'],
//            ['id' => null, 'id_padre' => 3, 'nombre' => 'Apoyo Operativo'],
//            ['id' => null, 'id_padre' => 3, 'nombre' => 'Chofer'],
//            ['id' => null, 'id_padre' => 3, 'nombre' => 'Chofer Dirección'],
//            ['id' => null, 'id_padre' => 3, 'nombre' => 'Delegado'],
//            ['id' => null, 'id_padre' => 3, 'nombre' => 'Mecánico'],
//            ['id' => null, 'id_padre' => 3, 'nombre' => 'Motos'],
//            ['id' => null, 'id_padre' => 3, 'nombre' => 'Motos/Alcoholemia'],

//            ['id' => null, 'id_padre' => null, 'nombre' => 'Otro'],
        
        ];
        
        foreach ($funciones as $funcion) {
            
            Funcion::create($funcion);
        }
    }
}
