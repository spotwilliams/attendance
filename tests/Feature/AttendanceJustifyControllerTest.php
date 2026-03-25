<?php

use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Mockery;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create();
    Gate::before(fn () => true);
});

// ---------------------------------------------------------------------------
// Auth guard
// ---------------------------------------------------------------------------

it('rejects unauthenticated requests to justify', function (): void {
    $presentismo = Presentismo::factory()->create(['injustificado' => true]);

    $this->postJson("/app/attendance/{$presentismo->id}/justify")
        ->assertUnauthorized();
});

it('rejects unauthenticated requests to unjustify', function (): void {
    $presentismo = Presentismo::factory()->create(['injustificado' => false]);

    $this->postJson("/app/attendance/{$presentismo->id}/unjustify")
        ->assertUnauthorized();
});

// ---------------------------------------------------------------------------
// 404
// ---------------------------------------------------------------------------

it('returns 404 for a non-existent presentismo on justify', function (): void {
    $this->actingAs($this->user)
        ->postJson('/app/attendance/99999/justify')
        ->assertNotFound();
});

it('returns 404 for a non-existent presentismo on unjustify', function (): void {
    $this->actingAs($this->user)
        ->postJson('/app/attendance/99999/unjustify')
        ->assertNotFound();
});

// ---------------------------------------------------------------------------
// Unjustify — happy path (simpler, no complex rules in Injustificar)
// ---------------------------------------------------------------------------

it('unjustifies a justified attendance record', function (): void {
    $tipo = TipoPresentismo::factory()->ausente()->create(['es_fijo' => false]);

    $presentismo = Presentismo::factory()->create([
        'injustificado' => false,
        'id_tipo_presentismo' => $tipo->id,
    ]);

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/unjustify")
        ->assertOk()
        ->assertJsonPath('message', 'Se ha injustificado la falta.');

    expect($presentismo->fresh()->injustificado)->toBeTrue();
});

// ---------------------------------------------------------------------------
// Validation error — es_fijo blocks justify/unjustify
// ---------------------------------------------------------------------------

it('returns 422 when tipo presentismo cannot be justified', function (): void {
    $tipo = TipoPresentismo::factory()->ausente()->create(['es_fijo' => true]);
    $presentismo = Presentismo::factory()->create([
        'injustificado' => true,
        'id_tipo_presentismo' => $tipo->id,
    ]);

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/justify")
        ->assertUnprocessable();

    expect($presentismo->fresh()->injustificado)->toBeTrue();
});

it('returns 422 when tipo presentismo cannot be unjustified', function (): void {
    $tipo = TipoPresentismo::factory()->ausente()->create(['es_fijo' => true]);
    $presentismo = Presentismo::factory()->create([
        'injustificado' => false,
        'id_tipo_presentismo' => $tipo->id,
    ]);

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/unjustify")
        ->assertUnprocessable();

    expect($presentismo->fresh()->injustificado)->toBeFalse();
});

// ---------------------------------------------------------------------------
// Response structure
// ---------------------------------------------------------------------------

it('returns presentismo with tipo_presentismo in unjustify response', function (): void {
    $tipo = TipoPresentismo::factory()->ausente()->create(['es_fijo' => false]);

    $presentismo = Presentismo::factory()->create([
        'injustificado' => false,
        'id_tipo_presentismo' => $tipo->id,
    ]);

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/unjustify")
        ->assertOk()
        ->assertJsonStructure([
            'message',
            'presentismo' => ['id', 'injustificado', 'tipo_presentismo'],
        ]);
});

// ---------------------------------------------------------------------------
// Justify — happy path
// ---------------------------------------------------------------------------

it('justifies an unjustified attendance record', function (): void {
    $tipo = TipoPresentismo::factory()->ausente()->create(['es_fijo' => false]);

    $presentismo = Presentismo::factory()->create([
        'injustificado' => true,
        'id_tipo_presentismo' => $tipo->id,
    ]);

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/justify")
        ->assertOk()
        ->assertJsonPath('message', 'Se ha justificado la falta.');

    expect($presentismo->fresh()->injustificado)->toBeFalse();
});

it('returns presentismo with tipo_presentismo in justify response', function (): void {
    $tipo = TipoPresentismo::factory()->ausente()->create(['es_fijo' => false]);

    $presentismo = Presentismo::factory()->create([
        'injustificado' => true,
        'id_tipo_presentismo' => $tipo->id,
    ]);

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/justify")
        ->assertOk()
        ->assertJsonStructure([
            'message',
            'presentismo' => ['id', 'injustificado', 'tipo_presentismo'],
        ]);
});

// ---------------------------------------------------------------------------
// Gate denial — 403
// ---------------------------------------------------------------------------

it('returns 403 when the gate denies justify', function (): void {
    Gate::partialMock()
        ->shouldReceive('allows')
        ->with('work-licencia', Mockery::type('array'))
        ->andReturn(false);

    $tipo = TipoPresentismo::factory()->ausente()->create(['es_fijo' => false]);
    $presentismo = Presentismo::factory()->create([
        'injustificado' => true,
        'id_tipo_presentismo' => $tipo->id,
    ]);

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/justify")
        ->assertForbidden()
        ->assertJsonPath('message', 'No tiene permisos para ejecutar');
});

it('returns 403 when the gate denies unjustify', function (): void {
    Gate::partialMock()
        ->shouldReceive('allows')
        ->with('work-licencia', Mockery::type('array'))
        ->andReturn(false);

    $tipo = TipoPresentismo::factory()->ausente()->create(['es_fijo' => false]);
    $presentismo = Presentismo::factory()->create([
        'injustificado' => false,
        'id_tipo_presentismo' => $tipo->id,
    ]);

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/unjustify")
        ->assertForbidden()
        ->assertJsonPath('message', 'No tiene permisos para ejecutar');
});

// ---------------------------------------------------------------------------
// 422 message content
// ---------------------------------------------------------------------------

it('returns a descriptive message when tipo presentismo blocks justify', function (): void {
    $tipo = TipoPresentismo::factory()->ausente()->create(['es_fijo' => true]);
    $presentismo = Presentismo::factory()->create([
        'injustificado' => true,
        'id_tipo_presentismo' => $tipo->id,
    ]);

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/justify")
        ->assertUnprocessable()
        ->assertJsonStructure(['message']);
});

it('returns a descriptive message when tipo presentismo blocks unjustify', function (): void {
    $tipo = TipoPresentismo::factory()->ausente()->create(['es_fijo' => true]);
    $presentismo = Presentismo::factory()->create([
        'injustificado' => false,
        'id_tipo_presentismo' => $tipo->id,
    ]);

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/unjustify")
        ->assertUnprocessable()
        ->assertJsonStructure(['message']);
});
