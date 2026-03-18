<?php

namespace Cat\Modules\Presentismo\Controllers\Registration;

use Cat\Http\Controllers\Controller;
use Cat\Models\Agente;
use Cat\Repositories\TipoPresentismosRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceTypesController extends Controller
{
    public function __invoke(Request $request, Agente $agent, string $date): JsonResponse
    {
        $request->merge(['date' => $date])->validate(['date' => 'required|date']);

        $types = TipoPresentismosRepository::getByTipoContratoOnDate(agente: $agent, date: $request->date('date'));

        return response()->json([
            'types' => $types->map(fn ($type) => [
                'id' => $type->id,
                'codigo' => $type->codigo,
                'descripcion' => $type->descripcion,
                'color' => $type->color,
                'color_letra' => $type->color_letra,
            ])->values(),
            'has_contract' => $types->isNotEmpty(),
        ]);
    }
}
