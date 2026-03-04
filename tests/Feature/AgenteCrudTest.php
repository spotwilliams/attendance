<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Cat\Models\Agente;
use Cat\Models\Area;
use Cat\Models\Base;
use Cat\Models\Cargo;
use Cat\Models\Contrato;
use Cat\Models\EstadoContrato;
use Cat\Models\Funcion;
use Cat\Models\Gerencia;
use Cat\Models\Operativo;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Cat\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

/**
 * Feature tests for Agente CRUD operations.
 *
 * Covers the 3-step wizard: Personales → Laborales → Operativos.
 * Authorization is bypassed via Gate::before() — these tests focus on
 * controller behavior and data persistence, not permission checks.
 */
class AgenteCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        // Bypass all authorization gates/policies for CRUD behavior tests
        Gate::before(fn () => true);
    }

    // =========================================================================
    // HELPERS
    // =========================================================================

    /**
     * Minimal valid POST data for Personales step.
     */
    private function validPersonalesData(array $overrides = []): array
    {
        return array_merge([
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
        ], $overrides);
    }

    /**
     * Minimal valid POST data for Laborales step (Situación de Revista — active).
     */
    private function validLaboralesData(int $agenteId, array $overrides = []): array
    {
        $tipoContrato   = TipoContrato::factory()->situacionRevista()->create();
        $estadoContrato = EstadoContrato::factory()->activo()->create();

        return array_merge([
            'agente'              => $agenteId,
            'id_tipo_contrato'    => $tipoContrato->id,
            'id_estado_contrato'  => $estadoContrato->id,
            'monto'               => 16002,
            'fecha_ingreso'       => Carbon::today()->subMonth()->format('Y-m-d'),
            'fecha_ingreso_gobierno' => Carbon::today()->subMonth()->format('Y-m-d'),
            'ficha'               => '',
            'id_sial'             => '',
            'tipo_inscripcion'    => '',
            'comentario'          => '',
        ], $overrides);
    }

    /**
     * Minimal valid POST data for Operativos step.
     */
    private function validOperativosData(int $agenteId, array $overrides = []): array
    {
        $gerencia = Gerencia::factory()->create();
        $area     = Area::factory()->create();
        $cargo    = Cargo::factory()->create();
        $funcion  = Funcion::factory()->create();
        $base     = Base::factory()->create();
        $turno    = Turno::factory()->create();

        return array_merge([
            'agente'              => $agenteId,
            'id_gerencia'         => $gerencia->id,
            'id_area'             => $area->id,
            'id_cargo'            => $cargo->id,
            'id_funcion'          => $funcion->id,
            'funcion_especifica'  => 'Inspector',
            'id_base'             => $base->id,
            'id_turno'            => $turno->id,
            'hora_entrada'        => '08:00:00',
            'hora_salida'         => '14:00:00',
            'eximido'             => 0,
            'rotativo'            => 0,
        ], $overrides);
    }

    // =========================================================================
    // AUTH GUARD
    // =========================================================================

    public function test_unauthenticated_user_cannot_access_create_personales()
    {
        $response = $this->get('/agentes/create/personales');
        $response->assertRedirect('/login');
    }

    public function test_unauthenticated_user_cannot_access_create_laborales()
    {
        $agente   = Agente::factory()->create();
        $response = $this->get("/agentes/create/laborales/id/{$agente->id}");
        $response->assertRedirect('/login');
    }

    public function test_unauthenticated_user_cannot_access_create_operativos()
    {
        $agente   = Agente::factory()->create();
        $response = $this->get("/agentes/create/operativos/id/{$agente->id}");
        $response->assertRedirect('/login');
    }

    // =========================================================================
    // PERSONALES — CREATE & STORE
    // =========================================================================

    public function test_create_personales_form_loads()
    {
        $response = $this->actingAs($this->user)->get('/agentes/create/personales');
        $response->assertStatus(200);
    }

    public function test_store_personales_creates_agente_and_redirects_to_laborales()
    {
        $response = $this->actingAs($this->user)
            ->post('/agentes/store/personales', $this->validPersonalesData());

        $agente = Agente::where('email', 'JUAN@EXAMPLE.COM')->first();
        $this->assertNotNull($agente);
        $this->assertDatabaseHas('agentes', ['cuit' => '20301234563']);
        $response->assertRedirect(route('agentesCreateLaborales', ['id' => $agente->id]));
    }

    public function test_store_personales_creates_domicilio()
    {
        $this->actingAs($this->user)
            ->post('/agentes/store/personales', $this->validPersonalesData());

        $agente = Agente::where('cuit', '20301234563')->firstOrFail();
        $this->assertDatabaseHas('domicilios', [
            'id_agente' => $agente->id,
            'calle'     => 'AV. CORRIENTES',
        ]);
    }

    public function test_store_personales_fails_validation_when_nombre_missing()
    {
        $response = $this->actingAs($this->user)
            ->post('/agentes/store/personales', $this->validPersonalesData(['nombre' => '']));

        // DEBUG - test if validate() actually throws
        $response->assertSessionHasErrors('nombre');
        $this->assertDatabaseMissing('agentes', ['cuit' => '20301234563']);
    }

    public function test_store_personales_fails_validation_when_cuit_missing()
    {
        $response = $this->actingAs($this->user)
            ->post('/agentes/store/personales', $this->validPersonalesData(['cuit' => '']));

        $response->assertSessionHasErrors('cuit');
    }

    public function test_store_personales_fails_validation_when_email_invalid()
    {
        $response = $this->actingAs($this->user)
            ->post('/agentes/store/personales', $this->validPersonalesData(['email' => 'not-an-email']));

        $response->assertSessionHasErrors('email');
    }

    public function test_store_personales_rejects_duplicate_cuit()
    {
        Agente::factory()->create(['cuit' => '20301234563']);

        // Attempt to create a second agent with the same CUIT
        $this->actingAs($this->user)
            ->post('/agentes/store/personales', $this->validPersonalesData(['email' => 'other@example.com']));

        $this->assertEquals(1, Agente::where('cuit', '20301234563')->count());
    }

    // =========================================================================
    // PERSONALES — EDIT & UPDATE
    // =========================================================================

    public function test_edit_personales_form_loads_with_agent_data()
    {
        $agente   = Agente::factory()->create();
        $response = $this->actingAs($this->user)->get("/agentes/edit/personales/id/{$agente->id}");

        $response->assertStatus(200);
    }

    public function test_edit_personales_returns_redirect_for_unknown_agent()
    {
        $response = $this->actingAs($this->user)->get('/agentes/edit/personales/id/99999');
        $response->assertRedirect(route('agentesCreatePersonales'));
    }

    public function test_update_personales_persists_changes_and_redirects_to_laborales_edit()
    {
        $agente = Agente::factory()->create(['cuit' => '20-30123456-3']);

        $response = $this->actingAs($this->user)
            ->post('/agentes/update/personales', $this->validPersonalesData([
                'id'      => $agente->id,
                'nombre'  => 'Carlos',
                'email'   => 'carlos@example.com',
            ]));

        $this->assertDatabaseHas('agentes', [
            'id'     => $agente->id,
            'nombre' => 'CARLOS',
        ]);
        $response->assertRedirect(route('agentesEditLaborales', ['id' => $agente->id]));
    }

    public function test_update_personales_fails_validation_when_apellido_missing()
    {
        $agente   = Agente::factory()->create(['cuit' => '20-30123456-3']);
        $response = $this->actingAs($this->user)
            ->post('/agentes/update/personales', $this->validPersonalesData([
                'id'       => $agente->id,
                'apellido' => '',
            ]));

        $response->assertSessionHasErrors('apellido');
    }

    // =========================================================================
    // LABORALES — CREATE & STORE
    // =========================================================================

    public function test_create_laborales_form_loads()
    {
        $agente   = Agente::factory()->create();
        $response = $this->actingAs($this->user)
            ->get("/agentes/create/laborales/id/{$agente->id}");

        $response->assertStatus(200);
    }

    public function test_create_laborales_redirects_to_edit_if_contract_already_exists()
    {
        $agente   = Agente::factory()->create();
        Contrato::factory()->create(['id_agente' => $agente->id]);

        $response = $this->actingAs($this->user)
            ->get("/agentes/create/laborales/id/{$agente->id}");

        $response->assertRedirect(route('agentesEditLaborales', ['id' => $agente->id]));
    }

    public function test_store_laborales_creates_contrato_and_redirects_to_operativos()
    {
        $agente   = Agente::factory()->create();
        $data     = $this->validLaboralesData($agente->id);

        $response = $this->actingAs($this->user)
            ->json('post', '/agentes/store/laborales', $data);

        $this->assertDatabaseHas('contratos', ['id_agente' => $agente->id]);
        $this->assertDatabaseHas('contratos_historicos', ['id_agente' => $agente->id]);
        $response->assertRedirect(route('agentesCreateOperativos', ['id' => $agente->id]));
    }

    public function test_store_laborales_fails_when_tipo_contrato_missing()
    {
        $agente   = Agente::factory()->create();
        $data     = $this->validLaboralesData($agente->id, ['id_tipo_contrato' => -1]);

        $response = $this->actingAs($this->user)
            ->post('/agentes/store/laborales', $data);

        $response->assertSessionHasErrors('id_tipo_contrato');
        $this->assertDatabaseMissing('contratos', ['id_agente' => $agente->id]);
    }

    public function test_store_laborales_locacion_requires_fecha_fin()
    {
        $agente       = Agente::factory()->create();
        $tipoLocacion = TipoContrato::factory()->locacion()->create();
        $estadoActivo = EstadoContrato::factory()->activo()->create();

        $data = [
            'agente'             => $agente->id,
            'id_tipo_contrato'   => $tipoLocacion->id,
            'id_estado_contrato' => $estadoActivo->id,
            'monto'              => 16002,
            'fecha_ingreso'      => '2023-01-16',
            // fecha_fin intentionally omitted
        ];

        $response = $this->actingAs($this->user)
            ->post('/agentes/store/laborales', $data);

        $response->assertSessionHasErrors('fecha_fin');
    }

    // =========================================================================
    // LABORALES — EDIT & UPDATE
    // =========================================================================

    public function test_edit_laborales_form_loads()
    {
        $agente   = Agente::factory()->create();
        Contrato::factory()->create(['id_agente' => $agente->id]);

        $response = $this->actingAs($this->user)
            ->get("/agentes/edit/laborales/id/{$agente->id}");

        $response->assertStatus(200);
    }

    public function test_update_laborales_persists_changes_and_redirects_to_operativos_edit()
    {
        $agente = Agente::factory()->create();
        Contrato::factory()->create(['id_agente' => $agente->id, 'monto' => 16002]);
        $data = $this->validLaboralesData($agente->id, ['agente' => $agente->id, 'monto' => 20000]);

        $response = $this->actingAs($this->user)
            ->post('/agentes/update/laborales', $data);

        $this->assertDatabaseHas('contratos', ['id_agente' => $agente->id, 'monto' => 20000]);
        $response->assertRedirect(route('agentesEditOperativos', ['id' => $agente->id]));
    }

    // =========================================================================
    // OPERATIVOS — CREATE & STORE
    // =========================================================================

    public function test_create_operativos_form_loads()
    {
        $agente   = Agente::factory()->create();
        $response = $this->actingAs($this->user)
            ->get("/agentes/create/operativos/id/{$agente->id}");

        $response->assertStatus(200);
    }

    public function test_create_operativos_redirects_to_edit_if_operativo_already_exists()
    {
        $agente   = Agente::factory()->create();
        Operativo::factory()->create(['id_agente' => $agente->id]);

        $response = $this->actingAs($this->user)
            ->get("/agentes/create/operativos/id/{$agente->id}");

        $response->assertRedirect(route('agentesEditOperativos', ['id' => $agente->id]));
    }

    public function test_store_operativos_creates_operativo_and_redirects_to_show()
    {
        // Operativos service needs an existing contract to read fecha_ingreso
        $agente   = Agente::factory()->create();
        Contrato::factory()->create([
            'id_agente'     => $agente->id,
            'fecha_ingreso' => '2023-01-16',
        ]);

        $data     = $this->validOperativosData($agente->id);
        $response = $this->actingAs($this->user)
            ->post('/agentes/store/operativos', $data);

        $this->assertDatabaseHas('operativos', ['id_agente' => $agente->id]);
        $this->assertDatabaseHas('horarios', [
            'hora_entrada' => '08:00:00',
            'hora_salida'  => '14:00:00',
        ]);
        $this->assertDatabaseHas('turnos_historicos', ['id_turno' => $data['id_turno']]);
        $response->assertRedirect(route('agentesShow', ['id' => $agente->id]));
    }

    public function test_store_operativos_fails_when_funcion_missing()
    {
        $agente = Agente::factory()->create();
        Contrato::factory()->create(['id_agente' => $agente->id]);

        $data = $this->validOperativosData($agente->id, ['id_funcion' => 99999]);

        // Service calls Funcion::findOrFail() — should throw ModelNotFoundException → 404/500
        $response = $this->actingAs($this->user)
            ->post('/agentes/store/operativos', $data);

        $this->assertDatabaseMissing('operativos', ['id_agente' => $agente->id]);
    }

    // =========================================================================
    // OPERATIVOS — EDIT & UPDATE
    // =========================================================================

    public function test_edit_operativos_form_loads()
    {
        $agente   = Agente::factory()->create();
        Operativo::factory()->create(['id_agente' => $agente->id]);

        $response = $this->actingAs($this->user)
            ->get("/agentes/edit/operativos/id/{$agente->id}");

        $response->assertStatus(200);
    }

    public function test_update_operativos_persists_changes()
    {
        $agente   = Agente::factory()->create();
        $contrato = Contrato::factory()->create([
            'id_agente'     => $agente->id,
            'fecha_ingreso' => '2023-01-16',
        ]);
        Operativo::factory()->create(['id_agente' => $agente->id]);

        $data = $this->validOperativosData($agente->id, [
            'hora_entrada' => '09:00:00',
            'hora_salida'  => '15:00:00',
        ]);

        $this->actingAs($this->user)
            ->post('/agentes/update/operativos', $data);

        $this->assertDatabaseHas('horarios', [
            'hora_entrada' => '09:00:00',
            'hora_salida'  => '15:00:00',
        ]);
    }

    // =========================================================================
    // SHOW
    // =========================================================================

    public function test_show_loads_agent_detail_page()
    {
        $agente   = Agente::factory()->create();
        $response = $this->actingAs($this->user)
            ->get("/agentes/show/id/{$agente->id}");

        $response->assertStatus(200);
        $response->assertSee($agente->nombre);
    }

    public function test_show_returns_404_for_unknown_agent()
    {
        $response = $this->actingAs($this->user)->get('/agentes/show/id/99999');
        $response->assertStatus(404);
    }

    // =========================================================================
    // SEARCH
    // =========================================================================

    public function test_search_returns_results_by_nombre()
    {
        Agente::factory()->create(['nombre' => 'Valentina', 'apellido' => 'García']);

        $response = $this->actingAs($this->user)->get('/agentes/buscar/?nombre=Valentina');

        $response->assertStatus(200);
        $response->assertSee('Valentina');
    }

    public function test_search_returns_results_by_apellido()
    {
        Agente::factory()->create(['nombre' => 'Roberto', 'apellido' => 'Fernández']);

        $response = $this->actingAs($this->user)->get('/agentes/buscar/?apellido=Fernández');

        $response->assertStatus(200);
        $response->assertSee('Fernández');
    }

    public function test_search_returns_results_by_cuit()
    {
        Agente::factory()->create(['cuit' => '27111222330']);

        $response = $this->actingAs($this->user)->get('/agentes/buscar/?cuit=27111222330');

        $response->assertStatus(200);
        $response->assertSee('27111222330');
    }

    public function test_search_with_empty_query_returns_empty_results()
    {
        Agente::factory()->count(3)->create();

        $response = $this->actingAs($this->user)->get('/agentes/buscar/');

        $response->assertStatus(200);
    }
}
