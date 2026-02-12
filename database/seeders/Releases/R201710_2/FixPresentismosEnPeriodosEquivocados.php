<?php

namespace Database\Seeders\Releases\R201710_2;

use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Illuminate\Database\Seeder;

class FixPresentismosEnPeriodosEquivocados extends Seeder
{

    public function run()
    {
        $periodos = Periodo::all();

        foreach ($periodos as $periodo) {
            $this->command->info('Periodo: ' . $periodo->toJson());
            $this->command->info('Se actualizaron: ' .
                Presentismo::whereDate('fecha', '>=', $periodo->fecha_comienzo)
                    ->whereDate('fecha', '<=', $periodo->fecha_fin)
                    ->where('id_periodo', '<>', $periodo->id)
                    ->update(['id_periodo' => $periodo->id])
            );
        }
    }
}
