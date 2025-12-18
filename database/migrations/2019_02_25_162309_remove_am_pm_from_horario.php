<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var \Illuminate\Support\Collection $horarios */
        $horarios = \Cat\Models\Horario::where('hora_entrada', 'LIKE', '%am%')
            ->orWhere('hora_salida', 'LIKE', '%pm%')
            ->get();

        /** @var \Cat\Models\Horario $horario */
        foreach ($horarios as $horario) {
            $horario->hora_entrada = str_replace('am', '', $horario->hora_entrada);
            $horario->hora_entrada = str_replace('pm', '', $horario->hora_entrada);

            $horario->hora_salida = str_replace('am', '', $horario->hora_salida);
            $horario->hora_salida = str_replace('pm', '', $horario->hora_salida);

            $horario->save();
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
};
