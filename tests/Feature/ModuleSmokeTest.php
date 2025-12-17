<?php

namespace Tests\Feature;

use Tests\TestCase;
use Cat\User;
use Cat\Models\Base;

/**
 * Smoke tests for all application modules.
 * These tests verify that each module's main pages load without errors.
 */
class ModuleSmokeTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::first();
    }

    /**
     * Skip test if no user available.
     */
    protected function requireUser()
    {
        if (!$this->user) {
            $this->markTestSkipped('No users in database');
        }
    }

    // ==========================================
    // HOME MODULE
    // ==========================================

    public function test_home_dashboard_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/home');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Dashboard should load or redirect appropriately'
        );
    }

    // ==========================================
    // AGENTES MODULE
    // ==========================================

    public function test_agentes_index_loads()
    {
        $this->requireUser();

        $base = Base::first();
        if (!$base) {
            $this->markTestSkipped('No bases in database');
        }

        $response = $this->actingAs($this->user)->get("/agentes/base/{$base->id}");

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Agentes index should load or redirect appropriately'
        );
    }

    public function test_agentes_create_personales_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/agentes/create/personales');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Agentes create personales should load or redirect appropriately'
        );
    }

    public function test_agentes_search_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/agentes/buscar/');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Agentes search should load or redirect appropriately'
        );
    }

    // ==========================================
    // PRESENTISMO MODULE
    // ==========================================

    public function test_presentismo_index_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/presentismo');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Presentismo index should load or redirect appropriately'
        );
    }

    public function test_presentismo_por_agente_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/presentismo/agente');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Presentismo por agente should load or redirect appropriately'
        );
    }

    // ==========================================
    // HABERES MODULE
    // ==========================================

    public function test_haberes_index_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/administracion/facturas/index');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Haberes index should load or redirect appropriately'
        );
    }

    public function test_haberes_notificacion_index_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/administracion/notificacion/index');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Haberes notificacion index should load or redirect appropriately'
        );
    }

    public function test_haberes_modificacion_masiva_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/administracion/modicacion/masivo/contrato');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Haberes modificacion masiva should load or redirect appropriately'
        );
    }

    // ==========================================
    // REPORTES MODULE
    // ==========================================

    public function test_reportes_agentes_general_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/reportes/agentes/general/');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Reportes agentes general should load or redirect appropriately'
        );
    }

    public function test_reportes_presentismo_general_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/reportes/presentismo/general/');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Reportes presentismo general should load or redirect appropriately'
        );
    }

    public function test_reportes_presentismo_individual_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/reportes/individual/');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Reportes presentismo individual should load or redirect appropriately'
        );
    }

    public function test_reportes_haberes_agente_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/reportes/haberes/agente/');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Reportes haberes agente should load or redirect appropriately'
        );
    }

    public function test_reportes_haberes_vista_previa_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/reportes/haberes/vista-previa/');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Reportes haberes vista previa should load or redirect appropriately'
        );
    }

    // ==========================================
    // CONFIGURACION MODULE
    // ==========================================

    public function test_configuracion_base_index_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/configuracion/base');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Configuracion base index should load or redirect appropriately'
        );
    }

    public function test_configuracion_area_index_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/configuracion/area');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Configuracion area index should load or redirect appropriately'
        );
    }

    public function test_configuracion_turno_index_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/configuracion/turno');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Configuracion turno index should load or redirect appropriately'
        );
    }

    public function test_configuracion_licencia_index_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/configuracion/licencia');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Configuracion licencia index should load or redirect appropriately'
        );
    }

    public function test_configuracion_fecha_cierre_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/fecha/cierre');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Configuracion fecha cierre should load or redirect appropriately'
        );
    }

    // ==========================================
    // SECURITY MODULE
    // ==========================================

    public function test_seguridad_usuarios_index_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/seguridad/usuario');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Seguridad usuarios index should load or redirect appropriately'
        );
    }

    public function test_seguridad_roles_index_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/seguridad/rol');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Seguridad roles index should load or redirect appropriately'
        );
    }

    public function test_seguridad_permisos_index_loads()
    {
        $this->requireUser();

        $response = $this->actingAs($this->user)->get('/seguridad/permission');

        $this->assertContains(
            $response->status(),
            [200, 302, 403],
            'Seguridad permisos index should load or redirect appropriately'
        );
    }
}
