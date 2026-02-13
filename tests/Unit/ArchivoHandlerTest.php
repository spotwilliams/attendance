<?php

namespace Tests\Unit;

use Cat\Models\ContratoHistorico;
use Cat\Models\EstadoContrato;
use Cat\Modules\Security\Models\Permission;
use Cat\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Cat\Modules\Masivo\Especificadores\Presentismos\ArchivoHandler;
use Cat\Models\Agente;
use Cat\Models\TipoPresentismo;
use Cat\Models\TipoContrato;
use Cat\Models\Contrato;
use Cat\Models\Base;

class ArchivoHandlerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::all());
        EstadoContrato::factory()->create(['estado' => 'COMISION']);

        Auth::login($user);
    }

    public function test_successful_import()
    {
        $tipoContrato = TipoContrato::factory()->create();

        Base::factory()->create();
        $agente = Agente::factory()->create(['cuit' => '12345678901']);
        $contrato = Contrato::factory()->create([
            'id_agente' => $agente->id,
            'id_tipo_contrato' => $tipoContrato->id,
        ]);
        $cotratoHistorico = ContratoHistorico::factory()->create([
            'id_agente' => $agente->id,
        ]);

        $agente->setRelation('contrato', $contrato->setRelation('TipoContrato', $tipoContrato));
        $agente->setRelation('contratoHistorico', $cotratoHistorico->setRelation('TipoContrato', $tipoContrato));
        TipoPresentismo::factory()->create([
            'codigo' => 'P',
            'descripcion' => 'Presente',
            'aplica' => 'TODOS',
        ]);
        $rows = new Collection([
            [
                'cuit' => $agente->cuit,
                'nombre' => $agente->nombre,
                'apellido' => $agente->apellido,
                '2026-02-13' => 'P',
                'fechas' => ['2026-02-13' => '2026-02-13']
            ]
        ]);
        $handler = new ArchivoHandler();
        $errors = $handler->handle($rows);
        $this->assertEmpty($errors);
    }

    public function test_presentismo_code_todos()
    {
        $tipoContrato = TipoContrato::factory()->create(['codigo' => 'LOCACION']);
        Base::factory()->create();
        $agente = Agente::factory()->create(['cuit' => '12345678901']);
        $contrato = Contrato::factory()->create([
            'id_agente' => $agente->id,
            'id_tipo_contrato' => $tipoContrato->id,
        ]);
        $agente->setRelation('contrato', $contrato->setRelation('TipoContrato', $tipoContrato));
        $tipoPresentismo = TipoPresentismo::factory()->create([
            'codigo' => 'P',
            'aplica' => 'TODOS',
            'descripcion' => 'Presente',
        ]);
        $rows = new Collection([
            [
                'cuit' => $agente->cuit,
                'nombre' => $agente->nombre,
                'apellido' => $agente->apellido,
                '2026-02-13' => 'P',
                'fechas' => ['2026-02-13' => '2026-02-13']
            ]
        ]);
        $handler = new ArchivoHandler();
        $errors = $handler->handle($rows);
        $this->assertEmpty($errors);
    }

    public function test_invalid_presentismo_code()
    {
        $tipoContrato = TipoContrato::factory()->create(['codigo' => 'A']);
        $base = Base::factory()->create();
        $agente = Agente::factory()->create(['cuit' => '12345678901']);
        $contrato = Contrato::factory()->create([
            'id_agente' => $agente->id,
            'id_tipo_contrato' => $tipoContrato->id,
        ]);
        $agente->setRelation('contrato', $contrato->setRelation('TipoContrato', $tipoContrato));
        $rows = new Collection([
            [
                'cuit' => $agente->cuit,
                'nombre' => $agente->nombre,
                'apellido' => $agente->apellido,
                '2026-02-13' => 'X',
                'fechas' => ['2026-02-13' => '2026-02-13']
            ]
        ]);
        $handler = new ArchivoHandler();
        $errors = $handler->handle($rows);
        $this->assertNotEmpty($errors);
        $this->assertEquals('El tipo de presentismo no se corresponde con el tipo de contrato. Intente manualmente desde la interfaz', $errors[0]['mensaje']);
    }

    public function test_missing_agent()
    {
        $rows = new Collection([
            [
                'cuit' => '99999999999',
                'nombre' => 'Jane',
                'apellido' => 'Smith',
                '2026-02-13' => 'P',
                'fechas' => ['2026-02-13' => '2026-02-13']
            ]
        ]);
        $handler = new ArchivoHandler();
        $errors = $handler->handle($rows);
        $this->assertNotEmpty($errors);
        $this->assertEquals('No se pudo procesar toda la fila', $errors[0]['mensaje']);
    }


    public function test_stops_on_empty_cuit()
    {
        $rows = new Collection([
            [
                'cuit' => 'empty',
                'nombre' => 'Stop',
                'apellido' => 'Here',
                '2026-02-13' => 'P',
                'fechas' => ['2026-02-13' => '2026-02-13']
            ],
            [
                'cuit' => '123',
                'nombre' => 'Should',
                'apellido' => 'NotRun',
                '2026-02-13' => 'P',
                'fechas' => ['2026-02-13' => '2026-02-13']
            ]
        ]);
        $handler = new ArchivoHandler();
        $errors = $handler->handle($rows);
        $this->assertEmpty($errors);
    }
}
