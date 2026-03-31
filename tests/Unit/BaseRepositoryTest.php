<?php

namespace Tests\Unit;

use Cat\Models\Area;
use Cat\Modules\Configuracion\Areas\Repositories\AreaRepository;
use Cat\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for the custom BaseRepository implementation.
 *
 * Uses AreaRepository as a concrete implementation since it extends
 * BaseRepository with the Area model. These tests verify all CRUD
 * methods introduced when prettus/l5-repository was removed.
 */
class BaseRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private AreaRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new AreaRepository();
    }

    // =========================================================================
    // model()
    // =========================================================================

    public function test_model_returns_area_class_string(): void
    {
        $this->assertSame(Area::class, $this->repository->model());
    }

    // =========================================================================
    // all()
    // =========================================================================

    public function test_all_returns_empty_collection_when_no_records(): void
    {
        $result = $this->repository->all();

        $this->assertCount(0, $result);
    }

    public function test_all_returns_all_records(): void
    {
        Area::factory()->count(3)->create();

        $result = $this->repository->all();

        $this->assertCount(3, $result);
    }

    public function test_all_returns_only_selected_columns(): void
    {
        Area::factory()->create(['nombre' => 'Test Area']);

        $result = $this->repository->all(['id', 'nombre']);

        $this->assertCount(1, $result);
        $this->assertArrayHasKey('nombre', $result->first()->toArray());
    }

    // =========================================================================
    // create()
    // =========================================================================

    public function test_create_persists_new_record_and_returns_model(): void
    {
        $result = $this->repository->create(['nombre' => 'Nueva Area']);

        $this->assertInstanceOf(Area::class, $result);
        $this->assertNotNull($result->id);
        $this->assertSame('Nueva Area', $result->nombre);
        $this->assertDatabaseHas('areas', ['nombre' => 'Nueva Area']);
    }

    public function test_create_returns_model_with_id(): void
    {
        $result = $this->repository->create(['nombre' => 'Area Con ID']);

        $this->assertGreaterThan(0, $result->id);
    }

    // =========================================================================
    // update()
    // =========================================================================

    public function test_update_modifies_record_and_returns_model(): void
    {
        $area = Area::factory()->create(['nombre' => 'Original']);

        $result = $this->repository->update(['nombre' => 'Updated'], $area->id);

        $this->assertInstanceOf(Area::class, $result);
        $this->assertSame('Updated', $result->nombre);
        $this->assertDatabaseHas('areas', ['id' => $area->id, 'nombre' => 'Updated']);
        $this->assertDatabaseMissing('areas', ['nombre' => 'Original']);
    }

    public function test_update_throws_model_not_found_for_nonexistent_id(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repository->update(['nombre' => 'X'], 9999);
    }

    // =========================================================================
    // delete()
    // =========================================================================

    public function test_delete_removes_record_from_database(): void
    {
        $area = Area::factory()->create();

        $result = $this->repository->delete($area->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('areas', ['id' => $area->id, 'deleted_at' => null]);
    }

    public function test_delete_throws_model_not_found_for_nonexistent_id(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repository->delete(9999);
    }

    // =========================================================================
    // findWithoutFail()
    // =========================================================================

    public function test_find_without_fail_returns_model_when_found(): void
    {
        $area = Area::factory()->create(['nombre' => 'Encontrada']);

        $result = $this->repository->findWithoutFail($area->id);

        $this->assertInstanceOf(Area::class, $result);
        $this->assertSame($area->id, $result->id);
        $this->assertSame('Encontrada', $result->nombre);
    }

    public function test_find_without_fail_returns_null_when_not_found(): void
    {
        $result = $this->repository->findWithoutFail(9999);

        $this->assertNull($result);
    }

    public function test_find_without_fail_accepts_column_selection(): void
    {
        $area = Area::factory()->create(['nombre' => 'Columnas']);

        $result = $this->repository->findWithoutFail($area->id, ['id', 'nombre']);

        $this->assertNotNull($result);
        $this->assertSame($area->id, $result->id);
    }

    // =========================================================================
    // find()
    // =========================================================================

    public function test_find_returns_model_when_record_exists(): void
    {
        $area = Area::factory()->create(['nombre' => 'Existe']);

        $result = $this->repository->find($area->id);

        $this->assertInstanceOf(Area::class, $result);
        $this->assertSame($area->id, $result->id);
    }

    public function test_find_throws_model_not_found_for_nonexistent_id(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repository->find(9999);
    }

    public function test_find_accepts_column_selection(): void
    {
        $area = Area::factory()->create(['nombre' => 'Columnas Find']);

        $result = $this->repository->find($area->id, ['id', 'nombre']);

        $this->assertNotNull($result);
        $this->assertSame($area->id, $result->id);
    }

    // =========================================================================
    // BaseRepository is abstract — subclass must declare model()
    // =========================================================================

    public function test_repository_is_instance_of_base_repository(): void
    {
        $this->assertInstanceOf(BaseRepository::class, $this->repository);
    }
}