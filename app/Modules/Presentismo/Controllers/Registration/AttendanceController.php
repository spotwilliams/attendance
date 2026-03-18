<?php

namespace Cat\Modules\Presentismo\Controllers\Registration;

use Cat\Http\Controllers\Controller;
use Cat\Models\Area;
use Cat\Models\Base;
use Cat\Models\Funcion;
use Cat\Models\Turno;
use Cat\Modules\Presentismo\Repositories\PresentismoRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AttendanceController extends Controller
{
    public function __construct(
        private PresentismoRepository $repository,
    ) {}

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
        $dateFrom = $formRequest->dateFrom();
        $dateTo = $formRequest->dateTo();

        $query = $this->repository
            ->getEloquentAgentesBetweenDates($base, $dateFrom, $dateTo)
            ->with([
                'presentismos' => function ($q) use ($dateFrom, $dateTo): void {
                    $q->whereDate('fecha', '>=', $dateFrom->format('Y-m-d'))
                        ->whereDate('fecha', '<=', $dateTo->format('Y-m-d'))
                        ->with('tipoPresentismo');
                },
                'contrato.tipoContrato',
                'operativo.turno',
                'operativo.area',
                'operativo.funcion',
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

        return $query->paginate(25)->toArray();
    }
}
