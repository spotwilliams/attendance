<?php

use Cat\Models\Agente;
use Cat\Models\Area;
use Cat\Models\Base;
use Cat\Models\Contrato;
use Cat\Models\EstadoContrato;
use Cat\Models\Funcion;
use Cat\Models\Operativo;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Models\Turno;
use Cat\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('requires authentication', function () {
    $this->get(route('attendance.index'))
        ->assertRedirect('/login');
});

it('renders the attendance page with filter options', function () {
    Base::factory()->create();
    Turno::factory()->create();
    Area::factory()->create();
    Funcion::factory()->create();

    $this->actingAs($this->user)
        ->get(route('attendance.index'))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Attendance/Index')
            ->has('bases', 1)
            ->has('shifts', 1)
            ->has('areas', 1)
            ->has('roles', 1)
            ->missing('agents')
                    );
});

it('does not include agents on initial page load', function () {
    $this->actingAs($this->user)
        ->get(route('attendance.index'))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->missing('agents')
                    );
});

it('returns paginated agents on partial reload', function () {
    $base = Base::factory()->create();
    $activeState = EstadoContrato::factory()->activo()->create();

    foreach (range(1, 3) as $i) {
        $agente = Agente::factory()->create(['apellido' => "Agent{$i}"]);
        Operativo::factory()->create([
            'id_agente' => $agente->id,
            'id_base' => $base->id,
        ]);
        Contrato::factory()->create([
            'id_agente' => $agente->id,
            'id_estado_contrato' => $activeState->id,
        ]);
    }

    $this->actingAs($this->user)
        ->get(route('attendance.index', [
            'base_id' => $base->id,
            'date_from' => now()->subDays(3)->format('Y-m-d'),
            'date_to' => now()->format('Y-m-d'),
        ]))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Attendance/Index')
            ->reloadOnly(['agents'],
                fn (Assert $reload) => $reload
                    ->has('agents.data', 3)
            )
        );
});

it('filters agents by shift', function () {
    $base = Base::factory()->create();
    $activeState = EstadoContrato::factory()->activo()->create();
    $turnoA = Turno::factory()->create(['codigo' => 'M']);
    $turnoB = Turno::factory()->create(['codigo' => 'T']);

    $agenteA = Agente::factory()->create(['apellido' => 'TurnoA']);
    Operativo::factory()->create([
        'id_agente' => $agenteA->id,
        'id_base' => $base->id,
        'id_turno' => $turnoA->id,
    ]);
    Contrato::factory()->create([
        'id_agente' => $agenteA->id,
        'id_estado_contrato' => $activeState->id,
    ]);

    $agenteB = Agente::factory()->create(['apellido' => 'TurnoB']);
    Operativo::factory()->create([
        'id_agente' => $agenteB->id,
        'id_base' => $base->id,
        'id_turno' => $turnoB->id,
    ]);
    Contrato::factory()->create([
        'id_agente' => $agenteB->id,
        'id_estado_contrato' => $activeState->id,
    ]);

    $this->actingAs($this->user)
        ->get(route('attendance.index', [
            'base_id' => $base->id,
            'date_from' => now()->subDays(3)->format('Y-m-d'),
            'date_to' => now()->format('Y-m-d'),
            'shifts' => [$turnoA->id],
        ]))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->reloadOnly(['agents'],
                fn (Assert $reload) => $reload
                    ->has('agents.data', 1)
                    ->where('agents.data.0.apellido', 'TURNOA')
            )
        );
});

it('filters agents by area', function () {
    $base = Base::factory()->create();
    $activeState = EstadoContrato::factory()->activo()->create();
    $areaA = Area::factory()->create();
    $areaB = Area::factory()->create();

    $agenteA = Agente::factory()->create(['apellido' => 'AreaA']);
    Operativo::factory()->create([
        'id_agente' => $agenteA->id,
        'id_base' => $base->id,
        'id_area' => $areaA->id,
    ]);
    Contrato::factory()->create([
        'id_agente' => $agenteA->id,
        'id_estado_contrato' => $activeState->id,
    ]);

    $agenteB = Agente::factory()->create(['apellido' => 'AreaB']);
    Operativo::factory()->create([
        'id_agente' => $agenteB->id,
        'id_base' => $base->id,
        'id_area' => $areaB->id,
    ]);
    Contrato::factory()->create([
        'id_agente' => $agenteB->id,
        'id_estado_contrato' => $activeState->id,
    ]);

    $this->actingAs($this->user)
        ->get(route('attendance.index', [
            'base_id' => $base->id,
            'date_from' => now()->subDays(3)->format('Y-m-d'),
            'date_to' => now()->format('Y-m-d'),
            'areas' => [$areaA->id],
        ]))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->reloadOnly(['agents'],
                fn (Assert $reload) => $reload
                    ->has('agents.data', 1)
                    ->where('agents.data.0.apellido', 'AREAA')
            )
        );
});

it('filters agents by role', function () {
    $base = Base::factory()->create();
    $activeState = EstadoContrato::factory()->activo()->create();
    $funcionA = Funcion::factory()->create();
    $funcionB = Funcion::factory()->create();

    $agenteA = Agente::factory()->create(['apellido' => 'RoleA']);
    Operativo::factory()->create([
        'id_agente' => $agenteA->id,
        'id_base' => $base->id,
        'id_funcion' => $funcionA->id,
    ]);
    Contrato::factory()->create([
        'id_agente' => $agenteA->id,
        'id_estado_contrato' => $activeState->id,
    ]);

    $agenteB = Agente::factory()->create(['apellido' => 'RoleB']);
    Operativo::factory()->create([
        'id_agente' => $agenteB->id,
        'id_base' => $base->id,
        'id_funcion' => $funcionB->id,
    ]);
    Contrato::factory()->create([
        'id_agente' => $agenteB->id,
        'id_estado_contrato' => $activeState->id,
    ]);

    $this->actingAs($this->user)
        ->get(route('attendance.index', [
            'base_id' => $base->id,
            'date_from' => now()->subDays(3)->format('Y-m-d'),
            'date_to' => now()->format('Y-m-d'),
            'roles' => [$funcionA->id],
        ]))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->reloadOnly(['agents'],
                fn (Assert $reload) => $reload
                    ->has('agents.data', 1)
                    ->where('agents.data.0.apellido', 'ROLEA')
            )
        );
});

it('paginates results at 25 per page', function () {
    $base = Base::factory()->create();
    $activeState = EstadoContrato::factory()->activo()->create();

    foreach (range(1, 30) as $i) {
        $agente = Agente::factory()->create(['apellido' => sprintf('Agent%03d', $i)]);
        Operativo::factory()->create([
            'id_agente' => $agente->id,
            'id_base' => $base->id,
        ]);
        Contrato::factory()->create([
            'id_agente' => $agente->id,
            'id_estado_contrato' => $activeState->id,
        ]);
    }

    $this->actingAs($this->user)
        ->get(route('attendance.index', [
            'base_id' => $base->id,
            'date_from' => now()->subDays(3)->format('Y-m-d'),
            'date_to' => now()->format('Y-m-d'),
        ]))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->reloadOnly(['agents'],
                fn (Assert $reload) => $reload
                    ->has('agents.data', 25)
                    ->where('agents.total', 30)
                    ->where('agents.current_page', 1)
                    ->where('agents.last_page', 2)
            )
        );
});

it('returns second page of results', function () {
    $base = Base::factory()->create();
    $activeState = EstadoContrato::factory()->activo()->create();

    foreach (range(1, 30) as $i) {
        $agente = Agente::factory()->create(['apellido' => sprintf('Agent%03d', $i)]);
        Operativo::factory()->create([
            'id_agente' => $agente->id,
            'id_base' => $base->id,
        ]);
        Contrato::factory()->create([
            'id_agente' => $agente->id,
            'id_estado_contrato' => $activeState->id,
        ]);
    }

    $this->actingAs($this->user)
        ->get(route('attendance.index', [
            'base_id' => $base->id,
            'date_from' => now()->subDays(3)->format('Y-m-d'),
            'date_to' => now()->format('Y-m-d'),
            'page' => 2,
        ]))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->reloadOnly(['agents'],
                fn (Assert $reload) => $reload
                    ->has('agents.data', 5)
                    ->where('agents.current_page', 2)
            )
        );
});

it('excludes agents from other bases', function () {
    $baseA = Base::factory()->create();
    $baseB = Base::factory()->create();
    $activeState = EstadoContrato::factory()->activo()->create();

    $agenteA = Agente::factory()->create(['apellido' => 'BaseA']);
    Operativo::factory()->create([
        'id_agente' => $agenteA->id,
        'id_base' => $baseA->id,
    ]);
    Contrato::factory()->create([
        'id_agente' => $agenteA->id,
        'id_estado_contrato' => $activeState->id,
    ]);

    $agenteB = Agente::factory()->create(['apellido' => 'BaseB']);
    Operativo::factory()->create([
        'id_agente' => $agenteB->id,
        'id_base' => $baseB->id,
    ]);
    Contrato::factory()->create([
        'id_agente' => $agenteB->id,
        'id_estado_contrato' => $activeState->id,
    ]);

    $this->actingAs($this->user)
        ->get(route('attendance.index', [
            'base_id' => $baseA->id,
            'date_from' => now()->subDays(3)->format('Y-m-d'),
            'date_to' => now()->format('Y-m-d'),
        ]))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->reloadOnly(['agents'],
                fn (Assert $reload) => $reload
                    ->has('agents.data', 1)
                    ->where('agents.data.0.apellido', 'BASEA')
            )
        );
});

it('excludes agents with inactive contracts', function () {
    $base = Base::factory()->create();
    $activeState = EstadoContrato::factory()->activo()->create();
    $bajaState = EstadoContrato::factory()->baja()->create();

    $activeAgent = Agente::factory()->create(['apellido' => 'Active']);
    Operativo::factory()->create([
        'id_agente' => $activeAgent->id,
        'id_base' => $base->id,
    ]);
    Contrato::factory()->create([
        'id_agente' => $activeAgent->id,
        'id_estado_contrato' => $activeState->id,
    ]);

    $inactiveAgent = Agente::factory()->create(['apellido' => 'Inactive']);
    Operativo::factory()->create([
        'id_agente' => $inactiveAgent->id,
        'id_base' => $base->id,
    ]);
    Contrato::factory()->create([
        'id_agente' => $inactiveAgent->id,
        'id_estado_contrato' => $bajaState->id,
    ]);

    $this->actingAs($this->user)
        ->get(route('attendance.index', [
            'base_id' => $base->id,
            'date_from' => now()->subDays(3)->format('Y-m-d'),
            'date_to' => now()->format('Y-m-d'),
        ]))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->reloadOnly(['agents'],
                fn (Assert $reload) => $reload
                    ->has('agents.data', 1)
                    ->where('agents.data.0.apellido', 'ACTIVE')
            )
        );
});

it('includes attendance records within date range', function () {
    $base = Base::factory()->create();
    $activeState = EstadoContrato::factory()->activo()->create();
    $presenteType = TipoPresentismo::factory()->presente()->create();

    $agente = Agente::factory()->create();
    Operativo::factory()->create([
        'id_agente' => $agente->id,
        'id_base' => $base->id,
    ]);
    $contrato = Contrato::factory()->create([
        'id_agente' => $agente->id,
        'id_estado_contrato' => $activeState->id,
    ]);

    $dateInRange = now()->subDays(2)->format('Y-m-d');
    Presentismo::factory()->create([
        'id_agente' => $agente->id,
        'id_tipo_presentismo' => $presenteType->id,
        'id_tipo_contrato' => $contrato->tipoContrato->id,
        'fecha' => $dateInRange,
    ]);

    $this->actingAs($this->user)
        ->get(route('attendance.index', [
            'base_id' => $base->id,
            'date_from' => now()->subDays(3)->format('Y-m-d'),
            'date_to' => now()->format('Y-m-d'),
        ]))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->reloadOnly(['agents'],
                fn (Assert $reload) => $reload
                    ->has('agents.data', 1)
                    ->has('agents.data.0.presentismos', 1)
                    ->where('agents.data.0.presentismos.0.tipo_presentismo.codigo', 'P')
            )
        );
});

it('excludes attendance records outside the date range', function () {
    $base = Base::factory()->create();
    $activeState = EstadoContrato::factory()->activo()->create();
    $presenteType = TipoPresentismo::factory()->presente()->create();
    $ausenteType = TipoPresentismo::factory()->ausente()->create();

    $agente = Agente::factory()->create();
    Operativo::factory()->create([
        'id_agente' => $agente->id,
        'id_base' => $base->id,
    ]);
    $contrato = Contrato::factory()->create([
        'id_agente' => $agente->id,
        'id_estado_contrato' => $activeState->id,
    ]);

    $dateFrom = now()->subDays(3)->format('Y-m-d');
    $dateTo = now()->format('Y-m-d');

    // Record inside the range — should be included
    Presentismo::factory()->create([
        'id_agente' => $agente->id,
        'id_tipo_presentismo' => $presenteType->id,
        'id_tipo_contrato' => $contrato->tipoContrato->id,
        'fecha' => now()->subDays(1)->format('Y-m-d'),
    ]);

    // Record before the range — should be excluded
    Presentismo::factory()->create([
        'id_agente' => $agente->id,
        'id_tipo_presentismo' => $ausenteType->id,
        'id_tipo_contrato' => $contrato->tipoContrato->id,
        'fecha' => now()->subDays(10)->format('Y-m-d'),
    ]);

    // Record after the range — should be excluded
    Presentismo::factory()->create([
        'id_agente' => $agente->id,
        'id_tipo_presentismo' => $ausenteType->id,
        'id_tipo_contrato' => $contrato->tipoContrato->id,
        'fecha' => now()->addDays(5)->format('Y-m-d'),
    ]);

    $this->actingAs($this->user)
        ->get(route('attendance.index', [
            'base_id' => $base->id,
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
        ]))
        ->assertSuccessful()
        ->assertInertia(fn (Assert $page) => $page
            ->reloadOnly(['agents'],
                fn (Assert $reload) => $reload
                    ->has('agents.data', 1)
                    ->has('agents.data.0.presentismos', 1)
                    ->where('agents.data.0.presentismos.0.tipo_presentismo.codigo', 'P')
            )
        );
});
