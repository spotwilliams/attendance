<?php

namespace Cat\Modules\Masivo\Especificadores\Presentismos;

use Cat\Models\Agente;
use Cat\Models\Base;
use Cat\Models\TipoPresentismo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Laracasts\Flash\Flash;
use Cat\Modules\Presentismo\Services\Helpers\Facilitador as StoreService;

class ArchivoHandler
{
    protected array $listaErrores = [];

    public function handle(Collection $rows): array
    {
        foreach ($rows as $row) {
            if (!isset($row['cuit']) || $row['cuit'] === 'empty') {
                break;
            }
            try {
                $agente = $this->getAgente($row);
                $listaPresentismo = $this->getDatesWithPresentismos($row, $agente);
                foreach ($listaPresentismo as $presente) {
                    try {
                        StoreService::validarDespuesGuardar($agente, $presente['tipo_presentismo'], $presente['fecha']);
                    } catch (\Exception $error) {
                        $this->listaErrores[] = [
                            'cuit'             => $agente->cuit,
                            'fecha'            => $presente['fecha']->format('Y-m-d'),
                            'tipo_presentismo' => $presente['tipo_presentismo']->descripcion,
                            'mensaje'          => $error->getMessage(),
                        ];
                    }
                }
            } catch (\Exception $e) {
                report($e);
                $this->listaErrores[] = [
                    'cuit'             => $row['cuit'] ?? '',
                    'fecha'            => 'N/A',
                    'tipo_presentismo' => 'N/A',
                    'mensaje'          => 'No se pudo procesar toda la fila',
                ];
            }
        }
        // Optionally, you can return the errors as a collection
        return $this->listaErrores;
    }

    private function getAgente(array $row): Agente
    {
        return Agente::where('cuit', '=', $row['cuit'])
            ->with('contrato.tipoContrato')
            ->firstOrFail();
    }

    private function getDatesWithPresentismos(array $row, Agente $agente): array
    {
        $data = $row;
        unset($data['nombre'], $data['apellido'], $data['cuit']);
        // Expect $row to have a 'fechas' key with the date mapping
        $fechas = isset($row['fechas']) ? $row['fechas'] : [];
        $return = [];
        foreach ($data as $fecha => $codigoPresentismo) {
            if ($fecha === 'fechas') continue;
            try {
                $tipoPresentismo = TipoPresentismo::where('codigo', '=', $codigoPresentismo)
                    ->where('aplica', '=', $agente->contrato->TipoContrato->codigo)
                    ->firstOrFail();
                $return [] = [
                    'fecha'            => new \DateTime($fechas[$fecha] ?? $fecha),
                    'tipo_presentismo' => $tipoPresentismo,
                ];
            } catch (ModelNotFoundException $noEncontratoPrimerIntento) {
                try {
                    $tipoPresentismo = TipoPresentismo::where('codigo', '=', $codigoPresentismo)
                        ->where('aplica', '=', 'TODOS')
                        ->firstOrFail();
                    $return [] = [
                        'fecha'            => new \DateTime($fechas[$fecha] ?? $fecha),
                        'tipo_presentismo' => $tipoPresentismo,
                    ];
                } catch (ModelNotFoundException $noEncontratoSegundoIntento) {
                    $this->listaErrores[] = [
                        'cuit'             => $row['cuit'],
                        'fecha'            => $fechas[$fecha] ?? $fecha,
                        'tipo_presentismo' => $codigoPresentismo,
                        'mensaje'          => 'El tipo de presentismo no se corresponde con el tipo de contrato. Intente manualmente desde la interfaz',
                    ];
                }
            }
        }
        return $return;
    }
}
