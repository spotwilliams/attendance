<?php

namespace Cat\Modules\Presentismo\Controllers\Registration;

use Cat\Http\Controllers\Controller;
use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Services\Helpers\Facilitador;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceStoreController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'agente' => 'required|exists:agentes,id',
            'fecha' => 'required|date',
            'presentismo' => 'required|integer',
        ]);

        $agente = Agente::findOrFail($request->input('agente'));
        $fecha = new \DateTime($request->input('fecha'));
        $tipoPresentismoId = (int) $request->input('presentismo');

        // Delete operation
        if ($tipoPresentismoId === -1) {
            return $this->destroy($agente, $fecha);
        }

        return $this->save($agente, $fecha, $tipoPresentismoId);
    }

    private function save(Agente $agente, \DateTime $fecha, int $tipoPresentismoId): JsonResponse
    {
        $tipoPresentismo = TipoPresentismo::findOrFail($tipoPresentismoId);

        try {
            Facilitador::validarDespuesGuardar($agente, $tipoPresentismo, $fecha);

            $presentismo = $agente->presentismos()
                ->whereDate('fecha', $fecha->format('Y-m-d'))
                ->with('tipoPresentismo')
                ->first();

            return response()->json([
                'message' => session()->get('message', 'Guardado correctamente'),
                'code' => session()->get('code', 200),
                'agente' => $agente->id,
                'presentismo' => $presentismo,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 422,
                'agente' => $agente->id,
                'presentismo' => null,
            ], 422);
        }
    }

    private function destroy(Agente $agente, \DateTime $fecha): JsonResponse
    {
        try {
            $presentismo = $agente->presentismos()
                ->whereDate('fecha', $fecha->format('Y-m-d'))
                ->first();

            if ($presentismo) {
                $presentismo->comentarios()->delete();
                $presentismo->delete();
            }

            return response()->json([
                'message' => 'Presentismo eliminado',
                'code' => 200,
                'agente' => $agente->id,
                'presentismo' => null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 422,
                'agente' => $agente->id,
                'presentismo' => null,
            ], 422);
        }
    }
}
