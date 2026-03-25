<?php

namespace Cat\Modules\Presentismo\Controllers\Registration;

use Cat\Http\Controllers\Controller;
use Cat\Models\Presentismo;
use Cat\Modules\Presentismo\Exceptions\Validacion\NoSePuedeInjustificar;
use Cat\Modules\Presentismo\Exceptions\Validacion\NoSePuedeJustificar;
use Cat\Modules\Presentismo\Exceptions\Validacion\Validation;
use Cat\Modules\Presentismo\Services\Registro\Injustificar;
use Cat\Modules\Presentismo\Services\Registro\Justificar;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class AttendanceJustifyController extends Controller
{
    public function justify(Presentismo $attendance): JsonResponse
    {
        $attendance->load(['tipoPresentismo', 'agente']);

        if (!Gate::allows('work-licencia', [$attendance->agente, $attendance->tipoPresentismo])) {
            return response()->json(['message' => 'No tiene permisos para ejecutar'], 403);
        }

        try {
            (new Justificar($attendance))->execute();
        } catch (Validation | NoSePuedeJustificar $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $attendance->refresh()->load('tipoPresentismo');

        return response()->json([
            'message' => 'Se ha justificado la falta.',
            'presentismo' => $attendance,
        ]);
    }

    public function unjustify(Presentismo $attendance): JsonResponse
    {
        $attendance->load(['tipoPresentismo', 'agente']);

        if (!Gate::allows('work-licencia', [$attendance->agente, $attendance->tipoPresentismo])) {
            return response()->json(['message' => 'No tiene permisos para ejecutar'], 403);
        }

        try {
            (new Injustificar($attendance))->execute();
        } catch (Validation | NoSePuedeInjustificar $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        $attendance->refresh()->load('tipoPresentismo');

        return response()->json([
            'message' => 'Se ha injustificado la falta.',
            'presentismo' => $attendance,
        ]);
    }
}
