<?php

use Carbon\Carbon;
use Cat\Models\Agente;
use Cat\Models\Contrato;
use Cat\Models\Operativo;
use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Models\TipoContrato;
use Cat\Models\TipoPresentismo;
use Cat\Models\Turno;
use Cat\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create();
    Gate::before(fn () => true);
});

/**
 * Minimal POST payload required by Reportes\Presentismos\Exportar@export.
 */
function exportPayload(string $desde, string $hasta): array
{
    return [
        'rango_desde'            => $desde,
        'rango_hasta'            => $hasta,
        'areas'                  => [],
        'bases'                  => [],
        'turnos'                 => [],
        'funcion'                => [],
        'estadoContratos'        => [],
        'tipoContratos'          => [],
        'tipo_presentismo'       => [],
        'incluir_sin_presentismo' => null,
    ];
}

// ---------------------------------------------------------------------------
// Auth guard
// ---------------------------------------------------------------------------

it('rejects unauthenticated requests to presentismo export', function (): void {
    $this->post('/reportes/presentismo/general/export', [])->assertRedirect('/login');
});

// ---------------------------------------------------------------------------
// Export — returns a streamable response (CSV/Excel)
// ---------------------------------------------------------------------------

it('returns a downloadable response for presentismo export', function (): void {
    $turno        = Turno::factory()->create();
    $tipoContrato = TipoContrato::factory()->create();
    $tipo         = TipoPresentismo::factory()->presente()->create();
    $agente       = Agente::factory()->create();
    $periodo      = Periodo::factory()->create([
        'fecha_comienzo' => Carbon::today()->subDays(15)->format('Y-m-d'),
        'fecha_fin'      => Carbon::today()->addDays(15)->format('Y-m-d'),
    ]);

    Contrato::factory()->create([
        'id_agente'        => $agente->id,
        'id_tipo_contrato' => $tipoContrato->id,
    ]);
    Operativo::factory()->create([
        'id_agente' => $agente->id,
        'id_turno'  => $turno->id,
    ]);
    Presentismo::factory()->create([
        'id_agente'           => $agente->id,
        'id_periodo'          => $periodo->id,
        'id_tipo_presentismo' => $tipo->id,
        'id_turno'            => $turno->id,
        'id_tipo_contrato'    => $tipoContrato->id,
        'fecha'               => Carbon::today()->format('Y-m-d'),
    ]);

    $desde  = Carbon::today()->subDays(15)->format('Y-m-d');
    $hasta  = Carbon::today()->addDays(15)->format('Y-m-d');

    $response = $this->actingAs($this->user)
        ->post('/reportes/presentismo/general/export', exportPayload($desde, $hasta));

    // Should be a streaming download, not a redirect or error
    $response->assertSuccessful();
});

// ---------------------------------------------------------------------------
// Export — no data still returns a valid response (no crash)
// ---------------------------------------------------------------------------

it('handles export with no matching data gracefully', function (): void {
    // No agents / presentismos seeded — export should not throw
    $desde = Carbon::today()->subDays(30)->format('Y-m-d');
    $hasta = Carbon::today()->format('Y-m-d');

    $response = $this->actingAs($this->user)
        ->post('/reportes/presentismo/general/export', exportPayload($desde, $hasta));

    // Either a successful download or a redirect back with a flash error — both acceptable
    expect($response->getStatusCode())->toBeIn([200, 302]);
});
