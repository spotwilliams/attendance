<?php

namespace Cat\Modules\Presentismo\Controllers\Registration;

use Cat\Http\Controllers\Controller;
use Cat\Models\Agente;
use Cat\Models\Area;
use Cat\Models\Base;
use Cat\Models\EstadoContrato;
use Cat\Models\Funcion;
use Cat\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class AttendanceController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Attendance/Index', [
            'bases' => fn () => Base::query()->orderBy('nombre')->get(['id', 'nombre']),
            'shifts' => fn () => Turno::query()->orderBy('descripcion')->get(['id', 'codigo', 'descripcion']),
            'areas' => fn () => Area::query()->orderBy('nombre')->get(['id', 'nombre']),
            'roles' => fn () => Funcion::query()->orderBy('nombre')->get(['id', 'nombre']),
            'agents' => Inertia::optional(fn () => $this->loadAgents($request)),
        ]);
    }

    private function loadAgents(Request $request): ?array
    {
        $validated = $request->validate(
            (new AttendanceAgentsRequest)->rules()
        );

        $base = Base::findOrFail($validated['base_id']);
        $formRequest = AttendanceAgentsRequest::createFrom($request);
        $dateFrom = $formRequest->dateFrom()->format('Y-m-d');
        $dateTo = $formRequest->dateTo()->format('Y-m-d');

        $activeStates = EstadoContrato::getEstadosEquivalentesActivos();

        $query = Agente::query()
            ->join('operativos', 'agentes.id', '=', 'operativos.id_agente')
            ->join('contratos', 'agentes.id', '=', 'contratos.id_agente')
            ->leftJoin('tipo_contratos', 'contratos.id_tipo_contrato', '=', 'tipo_contratos.id')
            ->where('operativos.id_base', $base->id)
            ->whereIn('contratos.id_estado_contrato', $activeStates->pluck('id'))
            ->where('contratos.fecha_ingreso', '<=', $dateTo)
            ->where(function ($q) use ($dateFrom): void {
                $q->whereNull('contratos.fecha_fin')
                    ->orWhere('contratos.fecha_fin', '>=', $dateFrom);
            })
            ->orderBy('agentes.apellido', 'asc')
            ->select([
                'agentes.id',
                'agentes.nombre',
                'agentes.apellido',
                'agentes.cuit',
                DB::raw("tipo_contratos.descripcion as contract_type"),
            ]);

        if ($request->filled('shifts')) {
            $query->whereIn('operativos.id_turno', $request->input('shifts'));
        }

        if ($request->filled('areas')) {
            $query->whereIn('operativos.id_area', $request->input('areas'));
        }

        if ($request->filled('roles')) {
            $query->whereIn('operativos.id_funcion', $request->input('roles'));
        }

        $paginated = $query->paginate(25);

        // Load presentismos with tipo_presentismo via a single query using join
        $agentIds = collect($paginated->items())->pluck('id');

        $presentismos = [];
        if ($agentIds->isNotEmpty()) {
            $rows = DB::table('presentismos')
                ->join('tipos_presentismos', 'presentismos.id_tipo_presentismo', '=', 'tipos_presentismos.id')
                ->whereIn('presentismos.id_agente', $agentIds)
                ->whereDate('presentismos.fecha', '>=', $dateFrom)
                ->whereDate('presentismos.fecha', '<=', $dateTo)
                ->select([
                    'presentismos.id',
                    'presentismos.id_agente',
                    'presentismos.fecha',
                    'presentismos.id_tipo_presentismo',
                    'presentismos.injustificado',
                    'tipos_presentismos.codigo as tipo_codigo',
                    'tipos_presentismos.descripcion as tipo_descripcion',
                    'tipos_presentismos.color as tipo_color',
                    'tipos_presentismos.color_letra as tipo_color_letra',
                ])
                ->get();

            foreach ($rows as $row) {
                $presentismos[$row->id_agente][] = [
                    'id' => $row->id,
                    'id_agente' => $row->id_agente,
                    'fecha' => $row->fecha,
                    'id_tipo_presentismo' => $row->id_tipo_presentismo,
                    'injustificado' => (bool) $row->injustificado,
                    'tipo_presentismo' => [
                        'id' => $row->id_tipo_presentismo,
                        'codigo' => $row->tipo_codigo,
                        'descripcion' => $row->tipo_descripcion,
                        'color' => $row->tipo_color,
                        'color_letra' => $row->tipo_color_letra,
                    ],
                ];
            }
        }

        // Transform paginated result
        $result = $paginated->toArray();
        $result['data'] = collect($result['data'])->map(fn($agent) => [
            'id' => $agent['id'],
            'nombre' => $agent['nombre'],
            'apellido' => $agent['apellido'],
            'cuit' => $agent['cuit'],
            'contract_type' => $agent['contract_type'],
            'has_contract' => $agent['contract_type'] !== null,
            'presentismos' => $presentismos[$agent['id']] ?? [],
        ])->all();

        return $result;
    }
}
