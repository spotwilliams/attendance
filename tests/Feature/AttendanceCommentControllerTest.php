<?php

use Cat\Models\Comentario;
use Cat\Models\Presentismo;
use Cat\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create();
    Gate::before(fn () => true);
});

// ---------------------------------------------------------------------------
// Index
// ---------------------------------------------------------------------------

it('rejects unauthenticated requests to list comments', function (): void {
    $presentismo = Presentismo::factory()->create();

    $this->getJson("/app/attendance/{$presentismo->id}/comments")
        ->assertUnauthorized();
});

it('returns an empty list when no comments exist', function (): void {
    $presentismo = Presentismo::factory()->create();

    $this->actingAs($this->user)
        ->getJson("/app/attendance/{$presentismo->id}/comments")
        ->assertOk()
        ->assertJsonCount(0, 'comments');
});

it('returns comments ordered by creation date', function (): void {
    $presentismo = Presentismo::factory()->create();

    $first = Comentario::create([
        'id_presentismo' => $presentismo->id,
        'id_user' => $this->user->id,
        'comentario' => 'First comment',
    ]);

    // Small delay to ensure ordering
    $second = Comentario::create([
        'id_presentismo' => $presentismo->id,
        'id_user' => $this->user->id,
        'comentario' => 'Second comment',
    ]);

    $this->actingAs($this->user)
        ->getJson("/app/attendance/{$presentismo->id}/comments")
        ->assertOk()
        ->assertJsonCount(2, 'comments')
        ->assertJsonPath('comments.0.comentario', 'First comment')
        ->assertJsonPath('comments.1.comentario', 'Second comment')
        ->assertJsonStructure([
            'comments' => [
                ['id', 'comentario', 'created_at', 'usuario'],
            ],
        ]);
});

// ---------------------------------------------------------------------------
// Store
// ---------------------------------------------------------------------------

it('rejects unauthenticated requests to store comments', function (): void {
    $presentismo = Presentismo::factory()->create();

    $this->postJson("/app/attendance/{$presentismo->id}/comments", [
        'comentario' => 'Test',
    ])->assertUnauthorized();
});

it('validates that comentario is required', function (): void {
    $presentismo = Presentismo::factory()->create();

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/comments", [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('comentario');
});

it('validates that comentario does not exceed 400 characters', function (): void {
    $presentismo = Presentismo::factory()->create();

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/comments", [
            'comentario' => str_repeat('a', 401),
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('comentario');
});

it('stores a comment and marks presentismo', function (): void {
    $presentismo = Presentismo::factory()->create();

    $response = $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/comments", [
            'comentario' => 'My test comment',
        ])
        ->assertCreated()
        ->assertJsonStructure([
            'comment' => ['id', 'comentario', 'created_at', 'usuario'],
        ])
        ->assertJsonPath('comment.comentario', 'My test comment');

    $this->assertDatabaseHas('comentarios', [
        'id_presentismo' => $presentismo->id,
        'id_user' => $this->user->id,
        'comentario' => 'My test comment',
    ]);

    expect($presentismo->fresh()->comentario)->toBe('SI');
});

it('returns 404 for a non-existent presentismo', function (): void {
    $this->actingAs($this->user)
        ->getJson('/app/attendance/99999/comments')
        ->assertNotFound();
});

// ---------------------------------------------------------------------------
// Boundary & format
// ---------------------------------------------------------------------------

it('accepts a comment of exactly 400 characters', function (): void {
    $presentismo = Presentismo::factory()->create();

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/comments", [
            'comentario' => str_repeat('x', 400),
        ])
        ->assertCreated();
});

it('returns created_at in ISO 8601 format', function (): void {
    $presentismo = Presentismo::factory()->create();

    $response = $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/comments", [
            'comentario' => 'ISO date check',
        ])
        ->assertCreated()
        ->json('comment.created_at');

    // ISO 8601 strings contain a 'T' separator between date and time
    expect($response)->toContain('T');
});

// ---------------------------------------------------------------------------
// Response content
// ---------------------------------------------------------------------------

it('includes the authenticated user name in the stored comment response', function (): void {
    $presentismo = Presentismo::factory()->create();

    $this->actingAs($this->user)
        ->postJson("/app/attendance/{$presentismo->id}/comments", [
            'comentario' => 'Name check',
        ])
        ->assertCreated()
        ->assertJsonPath('comment.usuario', $this->user->name);
});

it('includes the comment author name when listing comments', function (): void {
    $author = User::factory()->create(['name' => 'Jane Doe']);
    $presentismo = Presentismo::factory()->create();

    Comentario::create([
        'id_presentismo' => $presentismo->id,
        'id_user' => $author->id,
        'comentario' => 'Author name test',
    ]);

    $this->actingAs($this->user)
        ->getJson("/app/attendance/{$presentismo->id}/comments")
        ->assertOk()
        ->assertJsonPath('comments.0.usuario', 'Jane Doe');
});

// ---------------------------------------------------------------------------
// Isolation
// ---------------------------------------------------------------------------

it('only returns comments belonging to the requested presentismo', function (): void {
    $presentismo = Presentismo::factory()->create();
    $other = Presentismo::factory()->create();

    Comentario::create([
        'id_presentismo' => $presentismo->id,
        'id_user' => $this->user->id,
        'comentario' => 'Belongs here',
    ]);

    Comentario::create([
        'id_presentismo' => $other->id,
        'id_user' => $this->user->id,
        'comentario' => 'Other record',
    ]);

    $this->actingAs($this->user)
        ->getJson("/app/attendance/{$presentismo->id}/comments")
        ->assertOk()
        ->assertJsonCount(1, 'comments')
        ->assertJsonPath('comments.0.comentario', 'Belongs here');
});
