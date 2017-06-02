<?php
namespace Cat\Database\Seeds\Agentes;

use Cat\Models\Horario;
use Illuminate\Database\Seeder;

class Horarios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $horarios = [
            ['hora_entrada' => '00:00', 'hora_salida' => '06:00'],
            ['hora_entrada' => '00:00', 'hora_salida' => '07:00'],
            ['hora_entrada' => '05:00', 'hora_salida' => '12:00'],
            ['hora_entrada' => '05:30', 'hora_salida' => '12:30'],
            ['hora_entrada' => '06:00', 'hora_salida' => '12:00'],
            ['hora_entrada' => '06:00', 'hora_salida' => '13:00'],
            ['hora_entrada' => '06:00', 'hora_salida' => '18:00'],
            ['hora_entrada' => '06:30', 'hora_salida' => '13:30'],
            ['hora_entrada' => '07:00', 'hora_salida' => '14:00'],
            ['hora_entrada' => '07:00', 'hora_salida' => '19:00'],
            ['hora_entrada' => '08:00', 'hora_salida' => '15:00'],
            ['hora_entrada' => '08:00', 'hora_salida' => '20:00'],
            ['hora_entrada' => '08:30', 'hora_salida' => '15:30'],
            ['hora_entrada' => '09:00', 'hora_salida' => '15:00'],
            ['hora_entrada' => '09:00', 'hora_salida' => '16:00'],
            ['hora_entrada' => '09:00', 'hora_salida' => '19:00'],
            ['hora_entrada' => '09:00', 'hora_salida' => '21:00'],
            ['hora_entrada' => '10:00', 'hora_salida' => '17:00'],
            ['hora_entrada' => '10:00', 'hora_salida' => '22:00'],
            ['hora_entrada' => '11:00', 'hora_salida' => '18:00'],
            ['hora_entrada' => '12:00', 'hora_salida' => '00:00'],
            ['hora_entrada' => '12:00', 'hora_salida' => '18:00'],
            ['hora_entrada' => '12:00', 'hora_salida' => '19:00'],
            ['hora_entrada' => '13:00', 'hora_salida' => '20:00'],
            ['hora_entrada' => '14:00', 'hora_salida' => '21:00'],
            ['hora_entrada' => '14:30', 'hora_salida' => '21:30'],
            ['hora_entrada' => '14:30', 'hora_salida' => '22:30'],
            ['hora_entrada' => '15:00', 'hora_salida' => '22:00'],
            ['hora_entrada' => '16:00', 'hora_salida' => '23:00'],
            ['hora_entrada' => '17:00', 'hora_salida' => '00:00'],
            ['hora_entrada' => '17:00', 'hora_salida' => '05:00'],
            ['hora_entrada' => '18:00', 'hora_salida' => '00:00'],
            ['hora_entrada' => '18:00', 'hora_salida' => '01:00'],
            ['hora_entrada' => '18:00', 'hora_salida' => '06:00'],
            ['hora_entrada' => '19:00', 'hora_salida' => '07:00'],
            ['hora_entrada' => '20:00', 'hora_salida' => '08:00'],
            ['hora_entrada' => '21:00', 'hora_salida' => '04:00'],
            ['hora_entrada' => '21:00', 'hora_salida' => '09:00'],
            ['hora_entrada' => '22:00', 'hora_salida' => '05:00'],
            ['hora_entrada' => '22:00', 'hora_salida' => '06:30'],
            ['hora_entrada' => '22:30', 'hora_salida' => '05:30'],
            ['hora_entrada' => '23:00', 'hora_salida' => '06:00'],
            ['hora_entrada' => 'EXIMIDO', 'hora_salida' => 'EXIMIDO'],
            ['hora_entrada' => 'ROTATIVO', 'hora_salida' => 'ROTATIVO'],
        ];
        
        foreach ($horarios as $h) {
            Horario::create($h);
            
        }
    }
}
