<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeedTest extends TestCase
{
    /**
     * Test that migrate:fresh --seed runs without errors
     * and key tables are populated.
     */
    public function test_migrate_fresh_seed_completes_successfully()
    {
        $exitCode = Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);

        $this->assertEquals(0, $exitCode, 'migrate:fresh --seed should complete with exit code 0. Output: ' . Artisan::output());

        $this->assertDatabaseHas('users', []);
        $this->assertGreaterThan(0, \Cat\Models\Area::count(), 'Areas table should have records');
        $this->assertGreaterThan(0, \Cat\Models\Base::count(), 'Bases table should have records');
        $this->assertGreaterThan(0, \Cat\Models\Cargo::count(), 'Cargos table should have records');
        $this->assertGreaterThan(0, \Cat\Models\Turno::count(), 'Turnos table should have records');
        $this->assertGreaterThan(0, \Cat\Models\TipoContrato::count(), 'TipoContrato table should have records');
        $this->assertGreaterThan(0, \Cat\Models\TipoPresentismo::count(), 'TipoPresentismo table should have records');
        $this->assertGreaterThan(0, \Cat\Models\Gerencia::count(), 'Gerencias table should have records');
        $this->assertGreaterThan(0, \Cat\Models\Funcion::count(), 'Funciones table should have records');
        $this->assertGreaterThan(0, \Cat\Models\Agente::count(), 'Agentes table should have records');
        $this->assertEquals(4, \Cat\Models\Periodo::count(), 'Should have 4 periods');
        $this->assertGreaterThan(0, \Cat\Models\Presentismo::count(), 'Presentismos table should have records');

        // Reset database for other tests
        Artisan::call('migrate:fresh', ['--force' => true]);
    }
}
