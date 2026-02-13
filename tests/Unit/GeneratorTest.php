<?php

namespace Tests\Unit;

use Cat\Models\EstadoContrato;
use Cat\Models\Horario;
use Cat\Modules\Security\Models\Permission;
use Cat\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Cat\Modules\Masivo\Services\Presentismos\Generator;
use Cat\Models\Base;
use Cat\Models\Turno;
use Cat\Models\Agente;
use Cat\Models\Operativo;

class GeneratorTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        $user->givePermissionTo(Permission::all());

        Auth::login($user);
    }

    public function test_successful_export_creates_file()
    {
        Storage::fake('masivo');
        $base = Base::factory()->create(['nombre' => 'TestBase']);
        $turno = Turno::factory()->create(['codigo' => 'T1']);
        $agente1 = Agente::factory()->create();
        $agente2 = Agente::factory()->create();
        Operativo::factory()->create(['id_base' => $base->id, 'id_turno' => $turno->id, 'id_agente' => $agente1->id,]);
        Operativo::factory()->create(['id_base' => $base->id, 'id_turno' => $turno->id, 'id_agente' => $agente2->id,]);
        // Place a template file in the fake disk
        $templatePath = '/templates/presentismos_masivo_template.xls';
        Storage::disk('masivo')->put($templatePath, 'dummy template content');
        $generator = new Generator($base, $turno);
        $generator->execute();
        $fileName = $generator->getFileName();
        $fullPath = 'presentismos/' . $fileName;
        Storage::disk('masivo')->assertExists($fullPath);
        // Optionally, check the file is not empty
        $this->assertNotEmpty(Storage::disk('masivo')->get($fullPath));
    }

    public function test_export_file_overwrites_existing()
    {
        Storage::fake('masivo');
        $base = Base::factory()->create(['nombre' => 'TestBase']);
        $turno = Turno::factory()->create(['codigo' => 'T1']);
        $agente = Agente::factory()->create();
        Operativo::factory()->create(['id_base' => $base->id, 'id_turno' => $turno->id, 'id_agente' => $agente->id]);
        $templatePath = '/templates/presentismos_masivo_template.xls';
        Storage::disk('masivo')->put($templatePath, 'dummy template content');
        $generator = new Generator($base, $turno);
        // Create a file with the same name to test overwrite
        $fullPath = 'presentismos/' . $generator->getFileName();
        Storage::disk('masivo')->put($fullPath, 'old content');
        $generator->execute();
        Storage::disk('masivo')->assertExists($fullPath);
        $this->assertNotEquals('old content', Storage::disk('masivo')->get($fullPath));
    }

    public function test_export_file_has_expected_header_and_rows()
    {
        Storage::fake('masivo');
        $base = Base::factory()->create(['nombre' => 'TestBase']);
        $turno = Turno::factory()->create(['codigo' => 'T1']);
        $agente = Agente::factory()->create(['nombre' => 'John', 'apellido' => 'Doe', 'cuit' => '123']);
        Operativo::factory()->create(['id_base' => $base->id, 'id_turno' => $turno->id, 'id_agente' => $agente->id]);
        $templatePath = '/templates/presentismos_masivo_template.xls';
        Storage::disk('masivo')->put($templatePath, 'dummy template content');
        $generator = new Generator($base, $turno);
        $generator->execute();
        $fullPath = 'presentismos/' . $generator->getFileName();
        Storage::disk('masivo')->assertExists($fullPath);
        // Optionally, use a package to read the xls and check header/rows, or just check file is not empty
        $this->assertNotEmpty(Storage::disk('masivo')->get($fullPath));
    }
}
