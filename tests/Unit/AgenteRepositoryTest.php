<?php

namespace Tests\Unit;

use Cat\Models\Agente;
use Cat\Modules\Agentes\Repositories\AgenteRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for AgenteRepository standalone methods.
 *
 * AgenteRepository no longer extends BaseRepository; it provides its own
 * findWithoutFail() and delete() methods directly wrapping the Agente model.
 * These tests were introduced after prettus/l5-repository was removed.
 */
class AgenteRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private AgenteRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new AgenteRepository();
    }

    // =========================================================================
    // findWithoutFail()
    // =========================================================================

    public function test_find_without_fail_returns_agente_when_record_exists(): void
    {
        $agente = Agente::factory()->create();

        $result = $this->repository->findWithoutFail($agente->id);

        $this->assertInstanceOf(Agente::class, $result);
        $this->assertSame($agente->id, $result->id);
    }

    public function test_find_without_fail_returns_null_when_record_does_not_exist(): void
    {
        $result = $this->repository->findWithoutFail(9999);

        $this->assertNull($result);
    }

    public function test_find_without_fail_does_not_throw_on_missing_record(): void
    {
        // Should never throw — that is the contract of "WithoutFail"
        $result = $this->repository->findWithoutFail(0);

        $this->assertNull($result);
    }

    public function test_find_without_fail_returns_correct_agente_by_id(): void
    {
        $first  = Agente::factory()->create();
        $second = Agente::factory()->create();

        $result = $this->repository->findWithoutFail($second->id);

        $this->assertSame($second->id, $result->id);
        $this->assertNotSame($first->id, $result->id);
    }

    // =========================================================================
    // delete()
    // =========================================================================

    public function test_delete_soft_deletes_the_agente_and_returns_true(): void
    {
        $agente = Agente::factory()->create();

        $result = $this->repository->delete($agente->id);

        $this->assertTrue($result);
        // Agente uses SoftDeletes — record remains but deleted_at is set
        $this->assertSoftDeleted('agentes', ['id' => $agente->id]);
    }

    public function test_delete_throws_model_not_found_for_nonexistent_id(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repository->delete(9999);
    }

    public function test_delete_removes_agente_from_normal_queries_after_soft_delete(): void
    {
        $agente = Agente::factory()->create();

        $this->repository->delete($agente->id);

        $this->assertNull(Agente::find($agente->id));
    }

    public function test_delete_does_not_affect_other_agentes(): void
    {
        $target    = Agente::factory()->create();
        $bystander = Agente::factory()->create();

        $this->repository->delete($target->id);

        $this->assertNotNull(Agente::find($bystander->id));
    }

    // =========================================================================
    // Regression: repository is not tied to BaseRepository
    // =========================================================================

    public function test_repository_is_standalone_and_not_a_base_repository(): void
    {
        $this->assertNotInstanceOf(\Cat\Repositories\BaseRepository::class, $this->repository);
    }
}