<?php

use Cat\Models\Agente;
use Cat\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->user = User::factory()->create();
    Gate::before(fn () => true);
});

/**
 * Minimal valid personales payload, with an optional avatar file.
 */
function personalesPayloadWithAvatar(?UploadedFile $avatar = null): array
{
    $data = [
        'nombre'              => 'Juan',
        'apellido'            => 'Pérez',
        'dni'                 => '30123456',
        'fecha_nacimiento'    => '1990-05-15',
        'cuit'                => '20-30123456-3',
        'telefono_particular' => '1155667788',
        'email'               => 'juan@example.com',
        'sexo'                => 'M',
        'estado_civil'        => 'Soltero',
        'domicilio'           => [
            'id'            => [''],
            'calle'         => ['Av. Corrientes'],
            'numero'        => ['1234'],
            'libre'         => [''],
            'departamento'  => [''],
            'piso'          => [''],
            'barrio'        => [''],
            'provincia'     => ['Buenos Aires'],
            'codigo_postal' => ['1043'],
            'constituido'   => [0],
        ],
        'estudio' => [
            'id'           => [],
            'carrera'      => [],
            'institucion'  => [],
            'estado'       => [],
            'nivelestudio' => [],
        ],
    ];

    if ($avatar) {
        $data['avatar'] = $avatar;
    }

    return $data;
}

// ---------------------------------------------------------------------------
// No avatar — agent gets default avatar
// ---------------------------------------------------------------------------

it('stores agent with default avatar when no image is uploaded', function (): void {
    $this->actingAs($this->user)
        ->post('/agentes/store/personales', personalesPayloadWithAvatar());

    $agente = Agente::where('cuit', '20301234563')->firstOrFail();

    expect($agente->avatar)->toBe(Agente::$avatar);
});

// ---------------------------------------------------------------------------
// With avatar — file is processed and stored
// ---------------------------------------------------------------------------

it('stores agent with uploaded avatar', function (): void {
    // Use a real small JPEG so Intervention\Image can process it
    $avatar = UploadedFile::fake()->image('photo.jpg', 100, 100);

    $this->actingAs($this->user)
        ->post('/agentes/store/personales', personalesPayloadWithAvatar($avatar));

    $agente = Agente::where('cuit', '20301234563')->firstOrFail();

    // Avatar should no longer be the default placeholder
    expect($agente->avatar)->not->toBe(Agente::$avatar);

    // Clean up uploaded file
    $uploadedPath = public_path('/uploads/avatars/' . $agente->avatar);
    if (file_exists($uploadedPath)) {
        unlink($uploadedPath);
    }
});

// ---------------------------------------------------------------------------
// Update — avatar is replaced when a new one is uploaded
// ---------------------------------------------------------------------------

it('replaces avatar on agent update', function (): void {
    $agente = Agente::factory()->create(['cuit' => '20301234563']);

    $avatar = UploadedFile::fake()->image('new-photo.jpg', 100, 100);

    $this->actingAs($this->user)
        ->post('/agentes/update/personales', array_merge(
            personalesPayloadWithAvatar($avatar),
            ['id' => $agente->id]
        ));

    $agente->refresh();

    expect($agente->avatar)->not->toBe(Agente::$avatar);

    $uploadedPath = public_path('/uploads/avatars/' . $agente->avatar);
    if (file_exists($uploadedPath)) {
        unlink($uploadedPath);
    }
});
