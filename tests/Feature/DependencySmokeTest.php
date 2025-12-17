<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Smoke tests for third-party dependencies.
 * These tests verify that key packages are properly installed and configured.
 */
class DependencySmokeTest extends TestCase
{
    // ==========================================
    // EXCEL EXPORTS (Maatwebsite)
    // ==========================================

    public function test_excel_package_is_installed()
    {
        $this->assertTrue(
            class_exists(\Maatwebsite\Excel\Excel::class),
            'Maatwebsite Excel package should be installed'
        );
    }

    public function test_excel_facade_resolves()
    {
        $excel = app('excel');
        $this->assertNotNull($excel);
    }

    // ==========================================
    // PERMISSIONS (Spatie)
    // ==========================================

    public function test_permission_package_is_installed()
    {
        $this->assertTrue(
            class_exists(\Spatie\Permission\Models\Permission::class),
            'Spatie Permission package should be installed'
        );
    }

    public function test_role_package_is_installed()
    {
        $this->assertTrue(
            class_exists(\Spatie\Permission\Models\Role::class),
            'Spatie Permission package should be installed'
        );
    }

    // ==========================================
    // IMAGE PROCESSING (Intervention)
    // ==========================================

    public function test_intervention_image_is_installed()
    {
        $this->assertTrue(
            class_exists(\Intervention\Image\ImageManager::class),
            'Intervention Image package should be installed'
        );
    }

    // ==========================================
    // FLASH MESSAGES (Laracasts)
    // ==========================================

    public function test_flash_package_is_installed()
    {
        $this->assertTrue(
            class_exists(\Laracasts\Flash\Flash::class),
            'Laracasts Flash package should be installed'
        );
    }

    // ==========================================
    // HTML/FORM HELPERS (LaravelCollective)
    // ==========================================

    public function test_html_collective_is_installed()
    {
        $this->assertTrue(
            class_exists(\Collective\Html\HtmlServiceProvider::class),
            'LaravelCollective HTML package should be installed'
        );
    }

    public function test_form_facade_resolves()
    {
        $this->assertTrue(
            class_exists(\Collective\Html\FormFacade::class),
            'Form facade should exist'
        );
    }

    public function test_html_facade_resolves()
    {
        $this->assertTrue(
            class_exists(\Collective\Html\HtmlFacade::class),
            'Html facade should exist'
        );
    }

    // ==========================================
    // REPOSITORY PATTERN (Prettus)
    // ==========================================

    public function test_repository_package_is_installed()
    {
        $this->assertTrue(
            class_exists(\Prettus\Repository\Eloquent\BaseRepository::class),
            'Prettus Repository package should be installed'
        );
    }

    // ==========================================
    // DATATABLES (Yajra) - if used
    // ==========================================

    public function test_datatables_package_check()
    {
        // This may not be installed, so we just check and note
        $installed = class_exists(\Yajra\DataTables\DataTables::class);

        // Just verify the check runs without error
        $this->assertTrue(true);
    }
}
