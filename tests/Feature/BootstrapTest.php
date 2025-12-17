<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\AuthManager;
use Illuminate\Config\Repository;

/**
 * Tests that verify the application bootstraps correctly.
 * These are the most basic tests - if these fail, nothing else will work.
 */
class BootstrapTest extends TestCase
{
    /**
     * Test that the application boots without errors.
     */
    public function test_application_boots()
    {
        // If we get here without exceptions, the app booted successfully
        $this->assertTrue(app()->bound('router'));
        $this->assertTrue(app()->bound('config'));
        $this->assertTrue(app()->bound('db'));
    }

    /**
     * Test that the database connection works.
     */
    public function test_database_connection()
    {
        $pdo = DB::connection()->getPdo();
        $this->assertNotNull($pdo);
    }

    /**
     * Test that key services can be resolved from the container.
     */
    public function test_key_services_resolve()
    {
        $this->assertInstanceOf(AuthManager::class, app('auth'));
        $this->assertInstanceOf(Repository::class, app('config'));
    }

    /**
     * Test that the configuration is loaded.
     */
    public function test_configuration_loads()
    {
        $this->assertNotNull(config('app.env'));
        $this->assertNotNull(config('database.default'));
    }

    /**
     * Test that CAT-specific configuration exists.
     */
    public function test_cat_configuration_exists()
    {
        // Check if the CAT config file is loaded
        $this->assertTrue(
            config('cat') !== null,
            'CAT configuration file (config/cat.php) should be loaded'
        );
    }
}
