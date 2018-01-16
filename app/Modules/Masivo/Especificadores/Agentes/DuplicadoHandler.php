<?php

namespace Cat\Masivo\Especificadores\Agentes;

use Cat\Masivo\Especificadores\Archivo;
use Cat\Masivo\Especificadores\ExcelHandler;
use Cat\Masivo\Helpers\DataCleaner;
use Cat\Models\Agente;
use Cat\Models\Area;
use Cat\Models\Base;
use Cat\Models\Cargo;
use Cat\Models\Comentario;
use Cat\Models\Contrato;
use Cat\Models\Domicilio;
use Cat\Models\EstadoContrato;
use Cat\Models\Estudio;
use Cat\Models\Funcion;
use Cat\Models\Gerencia;
use Cat\Models\Operativo;
use Cat\Models\Presentismo;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Cat\Modules\Agentes\Services\Registro\Update\Operativos as OperativosStore;
use Cat\Modules\Agentes\Services\Registro\Destroy\Forced\Personales as PersonalesDestroy;
use Cat\Modules\Agentes\Services\Registro\Destroy\Forced\Laborales as LaboralesDestroy;
use Cat\Modules\Agentes\Services\Registro\Destroy\Forced\Operativos as OperativosDestroy;
use Cat\Masivo\Especificadores\Mappers\Operativos as OperativosMapper;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Collections\CellCollection;
use Cat\Masivo\Especificadores\Mappers\Personales as PersonalesMapper;
use Maatwebsite\Excel\Collections\RowCollection;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;

class DuplicadoHandler extends ExcelHandler
{
    
    public function handle($file)
    {
        /** @var Archivo $file */
        $listaErrores = [];
        
        /** @var Base $base */
        $base = $file->getBase();
        
        /** @var LaravelExcelWriter $fileErrores */
        $fileErrores = $this->generateOutFile($file->getFileName(), 'agentes');
        
        /** @var RowCollection $sheet */
        $sheet = $this->getSheet($file, 'procesado');
        
        for ($i = 0; $i < $sheet->count(); $i++) {
            /** @var CellCollection $row */
            $row = $sheet->get($i);
            try {
                if ($row->si !== 'end') {
                    /** @var Agente $model */
                    $modelBueno = $this->getModel($row->si);
                    $modelMalo  = $this->getModel($row->no);
                    
                    /** @var Presentismo $presentismo */
                    foreach ($modelMalo->presentismos()->get() as $presentismo) {
                        try {
                            $presentismo->update(['id_agente' => $modelBueno->id]);
                        } catch (QueryException $duplicado) {
                            // Si esta duplicado el bueno mantiene lo que tiene
                            Comentario::where('id_presentismo', '=', $presentismo->id)
                                ->delete();
                            $presentismo->delete();
                        }
                    }

                    foreach ($modelMalo->haberes()->get() as $haber) {
                        try {
                            $haber->update(['id_agente' => $modelBueno->id]);
                        } catch (QueryException $duplicado) {
                            // Si esta duplicado el bueno mantiene lo que tiene
                            $haber->delete();
                        }
                    }
                    
                    $this->delete(Contrato::class, $modelMalo);
                    $this->delete(Operativo::class, $modelMalo);
                    $this->delete(Estudio::class, $modelMalo);
                    $this->delete(Domicilio::class, $modelMalo);
                    
                    $modelMalo->forceDelete();
                    
                    
                    Log::info('Se realizo el cambio con cuit final: ' . $row->cuit);
                } else {
                    break;
                }
            } catch (\Exception $e) {
                Log::error($e);
                
                $listaErrores[] = [
                    '#'           => $i + 1,
                    'si'          => $row->si,
                    'no'          => $row->no,
                    'apellido'    => $row->apellido,
                    'nombre'      => $row->nombre,
                    'tech_reason' => $e->getMessage(),
                ];
            }
        }
        
        
        $fileErrores->sheet('Errores', function ($sheet) use ($listaErrores) {
            
            $sheet->fromArray($listaErrores);
            
        })->store('xls', $this->location, true);
        
        Flash::warning('Se finaliz&oacute; el proceso de importaci&oacute;n');
        
    }
    
    
    /**
     * @param string $cuit
     * @return Agente
     * @throws ModelNotFoundException
     */
    private function getModel($cuit)
    {
        $model = Agente::where('cuit', '=', $cuit)
            ->firstOrFail();
        
        
        return $model;
    }
    
    private function delete($class, Agente $modelMalo)
    {
        try {
            
            $relation = $class::withTrashed()
                ->where('id_agente', '=', $modelMalo->id)
                ->first();
            if ($relation) {
                $relation->forceDelete();
            }
        } catch (\Exception $e) {
            $relation = $class::where('id_agente', '=', $modelMalo->id)
                ->delete();
        }
    }
}