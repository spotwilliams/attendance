<?php

use Carbon\Carbon;
use Cat\Models\Agente;
use Cat\Models\ContratoHistorico;
use Cat\Models\EstadoContrato;
use Cat\Models\Operativo;
use Cat\Models\Presentismo;
use Cat\Models\TipoContrato;
use Cat\Models\TipoPresentismo;
use Cat\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create();
    Gate::before(fn () => true);
});

/**
 * Build the minimal payload required by RegistroController@registro.
 */
function attendancePayload(Agente $agente, TipoPresentismo $tipo, string $fecha): array
{
    return [
        'agente'      => $agente->id,
        'presentismo' => $tipo->id,
        'fecha'       => $fecha,
    ];
}

/**
 * Set up an agent with all required relationships for attendance recording.
 * Uses SITUACION_REVISTA so no invoice/factura check is triggered.
 */
function agentWithAttendanceSetup(): Agente
{
    // EnComision rule calls EstadoContrato::comision() which does a DB lookup —
    // it must exist or the rule crashes with "property on null".
    EstadoContrato::factory()->create(['estado' => 'COMISION', 'descripcion' => 'COMISION']);

    $agente        = Agente::factory()->create();
    $tipoContrato  = TipoContrato::factory()->situacionRevista()->create();

    // contratoOnDate() queries ContratoHistorico, not Contrato
    ContratoHistorico::factory()->create([
        'id_agente'          => $agente->id,
        'id_tipo_contrato'   => $tipoContrato->id,
        'fecha_ingreso'      => Carbon::today()->subYear()->format('Y-m-d'),
        'fecha_fin'          => Carbon::today()->addYear()->format('Y-m-d'),
    ]);

    Operativo::factory()->create(['id_agente' => $agente->id]);

    return $agente;
}

// ---------------------------------------------------------------------------
// Auth guard
// ---------------------------------------------------------------------------

it('rejects unauthenticated requests to attendance recording', function (): void {
    $this->post('/presentismo/registro', [])->assertRedirect('/login');
});

// ---------------------------------------------------------------------------
// Store — happy path
// ---------------------------------------------------------------------------

it('stores a new attendance record', function (): void {
    $agente = agentWithAttendanceSetup();
    $tipo   = TipoPresentismo::factory()->presente()->create();
    $fecha  = Carbon::today()->format('Y-m-d');

    $this->actingAs($this->user)
        ->postJson('/presentismo/registro', attendancePayload($agente, $tipo, $fecha))
        ->assertJson(['agente' => $agente->id]);

    $this->assertDatabaseHas('presentismos', [
        'id_agente'           => $agente->id,
        'id_tipo_presentismo' => $tipo->id,
    ]);
});

// ---------------------------------------------------------------------------
// Update — attendance already exists for that date
// ---------------------------------------------------------------------------

it('updates an existing attendance record for the same date', function (): void {
    $agente = agentWithAttendanceSetup();
    $tipo1  = TipoPresentismo::factory()->presente()->create();
    // Use a second presente tipo to avoid the Ausente rule which requires extra contract data
    $tipo2  = TipoPresentismo::factory()->presente()->create();
    $fecha  = Carbon::today()->format('Y-m-d');

    // Store first record
    $this->actingAs($this->user)
        ->postJson('/presentismo/registro', attendancePayload($agente, $tipo1, $fecha));

    $this->assertDatabaseHas('presentismos', ['id_agente' => $agente->id, 'id_tipo_presentismo' => $tipo1->id]);

    // Post again with a different tipo — should update
    $this->actingAs($this->user)
        ->postJson('/presentismo/registro', attendancePayload($agente, $tipo2, $fecha))
        ->assertJson(['agente' => $agente->id]);

    $this->assertDatabaseHas('presentismos', [
        'id_agente'           => $agente->id,
        'id_tipo_presentismo' => $tipo2->id,
    ]);
});

// ---------------------------------------------------------------------------
// Destroy — presentismo = -1 means delete
// ---------------------------------------------------------------------------

it('destroys an attendance record when presentismo is -1', function (): void {
    $agente = agentWithAttendanceSetup();
    $tipo   = TipoPresentismo::factory()->presente()->create();
    $fecha  = Carbon::today()->format('Y-m-d');

    // Store first
    $this->actingAs($this->user)
        ->postJson('/presentismo/registro', attendancePayload($agente, $tipo, $fecha));

    $this->assertDatabaseHas('presentismos', ['id_agente' => $agente->id]);

    // Destroy
    $this->actingAs($this->user)
        ->postJson('/presentismo/registro', [
            'agente'      => $agente->id,
            'presentismo' => -1,
            'fecha'       => $fecha,
        ])
        ->assertJson(['agente' => $agente->id]);

    $this->assertDatabaseMissing('presentismos', [
        'id_agente' => $agente->id,
        'fecha'     => $fecha,
    ]);
});
