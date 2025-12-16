<?php

namespace Tests\Feature;

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
 * Smoke tests for Eloquent models.
 * These tests verify that models can be loaded and their relationships work.
 */
class ModelSmokeTest extends TestCase
{
    // ==========================================
    // BASIC MODEL LOADING
    // ==========================================

    public function test_user_model_loads()
    {
        $user = User::first();
        $this->assertNotNull($user, 'Should have at least one user');
    }

    public function test_base_model_loads()
    {
        $base = Base::first();
        $this->assertNotNull($base, 'Should have at least one base');
    }

    public function test_area_model_loads()
    {
        $area = Area::first();
        $this->assertNotNull($area, 'Should have at least one area');
    }

    public function test_turno_model_loads()
    {
        $turno = Turno::first();
        $this->assertNotNull($turno, 'Should have at least one turno');
    }

    public function test_periodo_model_loads()
    {
        $periodo = Periodo::first();
        $this->assertNotNull($periodo, 'Should have at least one periodo');
    }

    public function test_tipo_presentismo_model_loads()
    {
        $tipo = TipoPresentismo::first();
        $this->assertNotNull($tipo, 'Should have at least one tipo presentismo');
    }

    public function test_tipo_contrato_model_loads()
    {
        $tipo = TipoContrato::first();
        $this->assertNotNull($tipo, 'Should have at least one tipo contrato');
    }

    // ==========================================
    // AGENTE RELATIONSHIPS
    // ==========================================

    public function test_agente_model_loads()
    {
        $agente = Agente::first();

        if (!$agente) {
            $this->markTestSkipped('No agentes in database');
        }

        $this->assertNotNull($agente);
    }

    public function test_agente_with_contrato_relationship()
    {
        $agente = Agente::has('contrato')->first();

        if (!$agente) {
            $this->markTestSkipped('No agentes with contrato in database');
        }

        $this->assertNotNull($agente->contrato);
    }

    public function test_agente_with_operativo_relationship()
    {
        $agente = Agente::has('operativo')->first();

        if (!$agente) {
            $this->markTestSkipped('No agentes with operativo in database');
        }

        $this->assertNotNull($agente->operativo);
    }

    public function test_agente_eager_loading_works()
    {
        $agente = Agente::with(['contrato', 'operativo'])->first();

        if (!$agente) {
            $this->markTestSkipped('No agentes in database');
        }

        // Just verify it doesn't throw an exception
        $this->assertNotNull($agente);
    }

    // ==========================================
    // PRESENTISMO RELATIONSHIPS
    // ==========================================

    public function test_presentismo_model_loads()
    {
        $presentismo = Presentismo::first();

        if (!$presentismo) {
            $this->markTestSkipped('No presentismos in database');
        }

        $this->assertNotNull($presentismo);
    }

    public function test_presentismo_belongs_to_agente()
    {
        $presentismo = Presentismo::has('agente')->first();

        if (!$presentismo) {
            $this->markTestSkipped('No presentismos with agente in database');
        }

        $this->assertNotNull($presentismo->agente);
    }

    public function test_presentismo_belongs_to_periodo()
    {
        $presentismo = Presentismo::has('periodo')->first();

        if (!$presentismo) {
            $this->markTestSkipped('No presentismos with periodo in database');
        }

        $this->assertNotNull($presentismo->periodo);
    }

    public function test_presentismo_belongs_to_tipo()
    {
        $presentismo = Presentismo::has('tipoPresentismo')->first();

        if (!$presentismo) {
            $this->markTestSkipped('No presentismos with tipo in database');
        }

        $this->assertNotNull($presentismo->tipoPresentismo);
    }

    // ==========================================
    // CONTRATO RELATIONSHIPS
    // ==========================================

    public function test_contrato_model_loads()
    {
        $contrato = Contrato::first();

        if (!$contrato) {
            $this->markTestSkipped('No contratos in database');
        }

        $this->assertNotNull($contrato);
    }

    public function test_contrato_belongs_to_agente()
    {
        $contrato = Contrato::has('agente')->first();

        if (!$contrato) {
            $this->markTestSkipped('No contratos with agente in database');
        }

        $this->assertNotNull($contrato->agente);
    }

    // ==========================================
    // QUERY SCOPES & COMPLEX QUERIES
    // ==========================================

    public function test_agente_query_with_multiple_joins()
    {
        // This tests that complex queries don't break after upgrades
        $query = Agente::query()
            ->with(['contrato', 'operativo'])
            ->limit(5);

        $results = $query->get();

        $this->assertNotNull($results);
    }

    public function test_presentismo_query_with_date_filters()
    {
        // Test date-based queries work
        $query = Presentismo::query()
            ->whereNotNull('fecha')
            ->limit(5);

        $results = $query->get();

        $this->assertNotNull($results);
    }
}
