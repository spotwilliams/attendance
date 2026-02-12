<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\Area;
use Cat\Models\Turno;
use Cat\Models\Periodo;
use Cat\Models\Presentismo;
use Cat\Models\Contrato;
use Cat\Models\TipoPresentismo;
use Cat\Models\TipoContrato;
use Cat\User;

/**
 * Smoke tests for Eloquent models and factories.
 * These tests verify that factories work correctly and model relationships function properly.
 */
class ModelSmokeTest extends TestCase
{
    use RefreshDatabase;

    // ==========================================
    // BASIC MODEL FACTORY TESTS
    // ==========================================

    public function test_user_factory_creates_user()
    {
        $user = User::factory()->create();

        $this->assertNotNull($user);
        $this->assertNotNull($user->name);
        $this->assertNotNull($user->email);
        $this->assertDatabaseHas('users', ['email' => $user->email]);
    }

    public function test_base_factory_creates_base()
    {
        $base = Base::factory()->create();

        $this->assertNotNull($base);
        $this->assertNotNull($base->nombre);
        $this->assertDatabaseHas('bases', ['nombre' => $base->nombre]);
    }

    public function test_area_factory_creates_area()
    {
        $area = Area::factory()->create();

        $this->assertNotNull($area);
        $this->assertNotNull($area->nombre);
        $this->assertDatabaseHas('areas', ['nombre' => $area->nombre]);
    }

    public function test_turno_factory_creates_turno()
    {
        $turno = Turno::factory()->create();

        $this->assertNotNull($turno);
        $this->assertNotNull($turno->codigo);
        $this->assertNotNull($turno->descripcion);
        $this->assertDatabaseHas('turnos', ['codigo' => $turno->codigo]);
    }

    public function test_periodo_factory_creates_periodo()
    {
        $periodo = Periodo::factory()->create();

        $this->assertNotNull($periodo);
        $this->assertNotNull($periodo->fecha_comienzo);
        $this->assertNotNull($periodo->fecha_fin);
        $this->assertEquals(30, $periodo->cant_dias);
        $this->assertDatabaseHas('periodos', ['id' => $periodo->id]);
    }

    public function test_tipo_presentismo_factory_creates_tipo()
    {
        $tipo = TipoPresentismo::factory()->create();

        $this->assertNotNull($tipo);
        $this->assertNotNull($tipo->codigo);
        $this->assertNotNull($tipo->descripcion);
        $this->assertDatabaseHas('tipos_presentismos', ['codigo' => $tipo->codigo]);
    }

    public function test_tipo_presentismo_factory_with_state_presente()
    {
        $tipo = TipoPresentismo::factory()->presente()->create();

        $this->assertEquals('P', $tipo->codigo);
        $this->assertEquals('Presente', $tipo->descripcion);
        $this->assertEquals('TODOS', $tipo->aplica);
    }

    public function test_tipo_contrato_factory_creates_tipo()
    {
        $tipo = TipoContrato::factory()->create();

        $this->assertNotNull($tipo);
        $this->assertNotNull($tipo->codigo);
        $this->assertDatabaseHas('tipo_contratos', ['codigo' => $tipo->codigo]);
    }

    public function test_tipo_contrato_factory_with_state_locacion()
    {
        $tipo = TipoContrato::factory()->locacion()->create();

        $this->assertEquals('LOCACION', $tipo->codigo);
        $this->assertEquals('Locación de Servicios', $tipo->descripcion);
    }

    // ==========================================
    // AGENTE FACTORY & RELATIONSHIPS
    // ==========================================

    public function test_agente_factory_creates_agente()
    {
        $agente = Agente::factory()->create();

        $this->assertNotNull($agente);
        $this->assertNotNull($agente->nombre);
        $this->assertNotNull($agente->apellido);
        $this->assertNotNull($agente->dni);
        $this->assertNotNull($agente->cuit);
        $this->assertDatabaseHas('agentes', ['dni' => $agente->dni]);
    }

    public function test_agente_factory_can_create_multiple()
    {
        $agentes = Agente::factory()->count(5)->create();

        $this->assertCount(5, $agentes);
        $this->assertEquals(5, Agente::count());
    }

    // ==========================================
    // CONTRATO FACTORY & RELATIONSHIPS
    // ==========================================

    public function test_contrato_factory_creates_contrato()
    {
        $contrato = Contrato::factory()->create();

        $this->assertNotNull($contrato);
        $this->assertNotNull($contrato->id_agente);
        $this->assertNotNull($contrato->id_tipo_contrato);
        $this->assertEquals(16002, $contrato->monto);
        $this->assertDatabaseHas('contratos', ['id' => $contrato->id]);
    }

    public function test_contrato_belongs_to_agente()
    {
        $agente = Agente::factory()->create();
        $contrato = Contrato::factory()->create(['id_agente' => $agente->id]);

        $this->assertNotNull($contrato->agente);
        $this->assertEquals($agente->id, $contrato->agente->id);
    }

    public function test_contrato_belongs_to_tipo_contrato()
    {
        $tipoContrato = TipoContrato::factory()->locacion()->create();
        $contrato = Contrato::factory()->create(['id_tipo_contrato' => $tipoContrato->id]);

        $this->assertNotNull($contrato->tipoContrato);
        $this->assertEquals('LOCACION', $contrato->tipoContrato->codigo);
    }

    // ==========================================
    // PRESENTISMO FACTORY & RELATIONSHIPS
    // ==========================================

    public function test_presentismo_factory_creates_presentismo()
    {
        $presentismo = Presentismo::factory()->create();

        $this->assertNotNull($presentismo);
        $this->assertNotNull($presentismo->id_agente);
        $this->assertNotNull($presentismo->id_periodo);
        $this->assertNotNull($presentismo->id_tipo_presentismo);
        $this->assertNotNull($presentismo->fecha);
        $this->assertDatabaseHas('presentismos', ['id' => $presentismo->id]);
    }

    public function test_presentismo_belongs_to_agente()
    {
        $agente = Agente::factory()->create();
        $presentismo = Presentismo::factory()->create(['id_agente' => $agente->id]);

        $this->assertNotNull($presentismo->agente);
        $this->assertEquals($agente->id, $presentismo->agente->id);
    }

    public function test_presentismo_belongs_to_tipo()
    {
        $tipo = TipoPresentismo::factory()->presente()->create();
        $presentismo = Presentismo::factory()->create(['id_tipo_presentismo' => $tipo->id]);

        $this->assertNotNull($presentismo->tipoPresentismo);
        $this->assertEquals('P', $presentismo->tipoPresentismo->codigo);
    }

    public function test_presentismo_belongs_to_turno()
    {
        $turno = Turno::factory()->create();
        $presentismo = Presentismo::factory()->create(['id_turno' => $turno->id]);

        $this->assertNotNull($presentismo->turno);
        $this->assertEquals($turno->codigo, $presentismo->turno->codigo);
    }

    // ==========================================
    // COMPLEX RELATIONSHIP TESTS
    // ==========================================

    public function test_agente_with_contrato_and_presentismos()
    {
        // Create agente with related models
        $agente = Agente::factory()->create();
        $contrato = Contrato::factory()->create(['id_agente' => $agente->id]);
        $periodo = Periodo::factory()->create();
        $tipo = TipoPresentismo::factory()->presente()->create();

        $presentismo1 = Presentismo::factory()->create([
            'id_agente' => $agente->id,
            'id_periodo' => $periodo->id,
            'id_tipo_presentismo' => $tipo->id,
        ]);

        $presentismo2 = Presentismo::factory()->create([
            'id_agente' => $agente->id,
            'id_periodo' => $periodo->id,
            'id_tipo_presentismo' => $tipo->id,
        ]);

        $this->assertNotNull($agente);
        $this->assertNotNull($contrato->agente);
        $this->assertEquals($agente->id, $presentismo1->agente->id);
        $this->assertEquals($agente->id, $presentismo2->agente->id);
    }

    public function test_batch_creation_with_factories()
    {
        // Test creating multiple related records
        $periodo = Periodo::factory()->create();
        $agentes = Agente::factory()->count(3)->create();
        $tipo = TipoPresentismo::factory()->presente()->create();

        foreach ($agentes as $agente) {
            Presentismo::factory()->create([
                'id_agente' => $agente->id,
                'id_periodo' => $periodo->id,
                'id_tipo_presentismo' => $tipo->id,
            ]);
        }

        $this->assertEquals(3, Agente::count());
        $this->assertEquals(3, Presentismo::count());
        $this->assertEquals(1, Periodo::count());
    }

    // ==========================================
    // QUERY SCOPES & COMPLEX QUERIES
    // ==========================================

    public function test_agente_query_with_eager_loading()
    {
        $agente = Agente::factory()->create();
        Contrato::factory()->create(['id_agente' => $agente->id]);

        // Test eager loading doesn't break
        $result = Agente::with(['contrato'])->first();

        $this->assertNotNull($result);
        $this->assertNotNull($result->contrato);
    }

    public function test_presentismo_query_with_date_filters()
    {
        $presentismo = Presentismo::factory()->create(['fecha' => '2024-01-15']);

        // Test date-based queries work
        $results = Presentismo::query()
            ->whereNotNull('fecha')
            ->where('fecha', '=', '2024-01-15')
            ->get();

        $this->assertCount(1, $results);
        $this->assertEquals('2024-01-15', $results->first()->fecha);
    }

    public function test_factory_creates_valid_cuit_format()
    {
        $agente = Agente::factory()->create();

        // CUIT format: XXXXXXXXXXX (11 digits, no dashes)
        $this->assertMatchesRegularExpression('/^\d{11}$/', $agente->cuit);
        $this->assertEquals(11, strlen($agente->cuit));
    }
}
