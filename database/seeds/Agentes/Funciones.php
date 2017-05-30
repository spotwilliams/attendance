<?php
namespace Cat\Database\Seeds\Agentes;

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
        
        $funciones = [
            [
                'id'               => 1,
                'id_funcion_padre' => null,
                'nombre'           => 'ADMINISTRATIVO',
            ],
            [
                'id'               => 2,
                'id_funcion_padre' => null,
                'nombre'           => 'APOYO OPERATIVO',
            ],
            [
                'id'               => 3,
                'id_funcion_padre' => null,
                'nombre'           => 'OPERATIVO',
            ],
            [
                'id'               => 4,
                'id_funcion_padre' => null,
                'nombre'           => 'PERSONAL SUPERIOR',
            ],
            
            // Hijos de 1 - Administrativo
            ['id_funcion_padre' => 1, 'nombre' => 'ACTAS',],
            ['id_funcion_padre' => 1, 'nombre' => 'ASUNTOS LEGALES',],
            ['id_funcion_padre' => 1, 'nombre' => 'AUTOS ABANDONADOS',],
            ['id_funcion_padre' => 1, 'nombre' => 'CAPACITACION',],
            ['id_funcion_padre' => 1, 'nombre' => 'CAPACITACION COORDINADOR',],
            ['id_funcion_padre' => 1, 'nombre' => 'CHOFER',],
            ['id_funcion_padre' => 1, 'nombre' => 'CHOFER GERENCIA OPERATIVA',],
            ['id_funcion_padre' => 1, 'nombre' => 'COMPRAS',],
            ['id_funcion_padre' => 1, 'nombre' => 'COMUNICACIONES Y ROPERIA',],
            ['id_funcion_padre' => 1, 'nombre' => 'COMUNICACIONES Y ROPERIA COORDINADOR',],
            ['id_funcion_padre' => 1, 'nombre' => 'COORDINADOR ACTAS',],
            ['id_funcion_padre' => 1, 'nombre' => 'COORDINADOR ALCOHOLEMIA TURNO NOCHE',],
            ['id_funcion_padre' => 1, 'nombre' => 'COORDINADOR DE AUTOS ABANDONADOS',],
            ['id_funcion_padre' => 1, 'nombre' => 'COORDINADOR GENERAL ALCOHOLEMIA',],
            ['id_funcion_padre' => 1, 'nombre' => 'COORDINADOR GRAL CUCC',],
            ['id_funcion_padre' => 1, 'nombre' => 'COORDINADOR TURNO MAÑANA ALCO',],
            ['id_funcion_padre' => 1, 'nombre' => 'DEPARTAMENTO DE PLANEAMIENTO',],
            ['id_funcion_padre' => 1, 'nombre' => 'DEPARTAMENTO DE PLANEAMIENTO COORDINADOR',],
            ['id_funcion_padre' => 1, 'nombre' => 'DESARROLLO HUMANO',],
            ['id_funcion_padre' => 1, 'nombre' => 'DESARROLLO HUMANO COORDINADOR',],
            ['id_funcion_padre' => 1, 'nombre' => 'ESTADISTICAS',],
            ['id_funcion_padre' => 1, 'nombre' => 'ESTADISTICAS COORDINADOR',],
            ['id_funcion_padre' => 1, 'nombre' => 'FISCALIZADORES',],
            ['id_funcion_padre' => 1, 'nombre' => 'GREMIO',],
            ['id_funcion_padre' => 1, 'nombre' => 'INFANTE',],
            ['id_funcion_padre' => 1, 'nombre' => 'LOGISTICA',],
            ['id_funcion_padre' => 1, 'nombre' => 'MANTENIMIENTO',],
            ['id_funcion_padre' => 1, 'nombre' => 'MANTENIMIENTO COORDINADOR',],
            ['id_funcion_padre' => 1, 'nombre' => 'MANTENIMIENTO SUPERVISOR',],
            ['id_funcion_padre' => 1, 'nombre' => 'MESA DE ENTRADA',],
            ['id_funcion_padre' => 1, 'nombre' => 'MESA DE ENTRADA COORDINADOR',],
            ['id_funcion_padre' => 1, 'nombre' => 'OPERADORES',],
            ['id_funcion_padre' => 1, 'nombre' => 'OPERATIVO',],
            ['id_funcion_padre' => 1, 'nombre' => 'PAÑOL',],
            ['id_funcion_padre' => 1, 'nombre' => 'PAÑOL COORDINADOR',],
            ['id_funcion_padre' => 1, 'nombre' => 'PAÑOL SUPERVISOR',],
            ['id_funcion_padre' => 1, 'nombre' => 'PERSONAL',],
            ['id_funcion_padre' => 1, 'nombre' => 'RECURSOS MATERIALES',],
            ['id_funcion_padre' => 1, 'nombre' => 'RELACIONES INSTITUCIONALES',],
            ['id_funcion_padre' => 1, 'nombre' => 'SEGURIDAD VIAL',],
            ['id_funcion_padre' => 1, 'nombre' => 'SISTEMAS',],
            ['id_funcion_padre' => 1, 'nombre' => 'SUPERVISOR ACTAS',],
            ['id_funcion_padre' => 1, 'nombre' => 'SUPERVISOR OPERADORES',],
            ['id_funcion_padre' => 1, 'nombre' => 'TALLER BALCARCE',],
            ['id_funcion_padre' => 1, 'nombre' => 'TALLER BALCARCE COORDINADOR',],
            
            // Hijos de 2 - Apoyo Operativo
            
            ['id_funcion_padre' => 2, 'nombre' => 'AGENTE COMBIS',],
            ['id_funcion_padre' => 2, 'nombre' => 'AGENTE PLAYA ACARREO',],
            ['id_funcion_padre' => 2, 'nombre' => 'COORDINADOR OPERATIVO DCER',],
            ['id_funcion_padre' => 2, 'nombre' => 'COORDINADOR PLAYAS DE ACARREO',],
            ['id_funcion_padre' => 2, 'nombre' => 'INFANTE',],
            ['id_funcion_padre' => 2, 'nombre' => 'INFANTE/ALCOHOLEMIA',],
            ['id_funcion_padre' => 2, 'nombre' => 'INFANTE-A',],
            ['id_funcion_padre' => 2, 'nombre' => 'SUPERVISOR INFANTES',],
            
            // Hijos de 3 -  Operativo
            ['id_funcion_padre' => 3, 'nombre' => 'ACTAS',],
            ['id_funcion_padre' => 3, 'nombre' => 'AGENTE COMBIS',],
            ['id_funcion_padre' => 3, 'nombre' => 'CHOFER',],
            ['id_funcion_padre' => 3, 'nombre' => 'CHOFER SUPERVISOR',],
            ['id_funcion_padre' => 3, 'nombre' => 'CHOFER/DIRECTOR',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR BRD FIN DE SEMANA',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR BRD GARAY',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR BRD SARMIENTO',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR CHOFER CHACABUCO',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR CHOFER FIN DE SEMANA',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR CHOFER FIN DE SEMANA DIURNO',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR CHOFER FIN DE SEMANA NOCHE',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR CHOFER LAS HERAS',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR CHOFER PIEDRAS',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR CHOFER SEF',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR FIN DE SEMANA DIURNO',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR FIN DE SEMANA NOCTURNO ALCO',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR GENERAL CHOFERES',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR GRAL CUCC',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR INTERMEDIO TARDE',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR TURNO MAÑANA',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR TURNO NOCHE',],
            ['id_funcion_padre' => 3, 'nombre' => 'COORDINADOR TURNO TARDE',],
            ['id_funcion_padre' => 3, 'nombre' => 'DEPARTAMENTO DE PLANEAMIENTO',],
            ['id_funcion_padre' => 3, 'nombre' => 'ESTADISTICAS',],
            ['id_funcion_padre' => 3, 'nombre' => 'GREMIO',],
            ['id_funcion_padre' => 3, 'nombre' => 'INFANTE',],
            ['id_funcion_padre' => 3, 'nombre' => 'INFANTE/ACOHOLEMIA',],
            ['id_funcion_padre' => 3, 'nombre' => 'INFANTE/ALCOHOLEMIA',],
            ['id_funcion_padre' => 3, 'nombre' => 'INFANTE-A',],
            ['id_funcion_padre' => 3, 'nombre' => 'JEFE DE BASE',],
            ['id_funcion_padre' => 3, 'nombre' => 'JEFE DE BASE GRUAS BRD',],
            ['id_funcion_padre' => 3, 'nombre' => 'MOTOS',],
            ['id_funcion_padre' => 3, 'nombre' => 'MOTOS/ALCOHOLEMIA',],
            ['id_funcion_padre' => 3, 'nombre' => 'OPERADORES',],
            ['id_funcion_padre' => 3, 'nombre' => 'OPERATIVO',],
            ['id_funcion_padre' => 3, 'nombre' => 'OPERATIVO/ALCOHOLEMIA',],
            ['id_funcion_padre' => 3, 'nombre' => 'PAÑOL',],
            ['id_funcion_padre' => 3, 'nombre' => 'SEGURIDAD VIAL',],
            ['id_funcion_padre' => 3, 'nombre' => 'SUPERVISOR',],
            ['id_funcion_padre' => 3, 'nombre' => 'SUPERVISOR AGENTES',],
            ['id_funcion_padre' => 3, 'nombre' => 'SUPERVISOR INFANTES',],
            ['id_funcion_padre' => 3, 'nombre' => 'SUPERVISOR INFANTES/ALCOHOLEMIA',],
            ['id_funcion_padre' => 3, 'nombre' => 'SUPERVISOR MOTOS',],
            ['id_funcion_padre' => 3, 'nombre' => 'SUPERVISOR MOTOS E INFANTES',],
            ['id_funcion_padre' => 3, 'nombre' => 'SUPERVISOR OPERADORES',],
            ['id_funcion_padre' => 3, 'nombre' => 'TALLER BALCARCE',],
            
            // Hijos de 4 -  Personal superior
            
            ['id_funcion_padre' => 4, 'nombre' => 'OPERATIVO',],
            ['id_funcion_padre' => 4, 'nombre' => 'PERSONAL',],
            ['id_funcion_padre' => 4, 'nombre' => 'RECURSOS MATERIALES',],
            ['id_funcion_padre' => 4, 'nombre' => 'SEGURIDAD VIAL',],
            ['id_funcion_padre' => 4, 'nombre' => 'SUBGERENTE OPERATIVO BASE CHACABUCO',],
            ['id_funcion_padre' => 4, 'nombre' => 'SUBGERENTE OPERATIVO BASE LAS HERAS',],
            ['id_funcion_padre' => 4, 'nombre' => 'SUBGERENTE OPERATIVO BASE PIEDRAS',],
        
        ];
        
        foreach ($funciones as $funcion) {
            
            Funcion::create($funcion);
        }
    }
}
