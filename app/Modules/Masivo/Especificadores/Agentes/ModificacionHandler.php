<?php

namespace Cat\Masivo\Especificadores\Agentes;

use Cat\Masivo\Especificadores\Archivo;
use Cat\Masivo\Especificadores\ExcelHandler;
use Cat\Masivo\Helpers\DataCleaner;
use Cat\Models\Agente;
use Cat\Models\Area;
use Cat\Models\Base;
use Cat\Models\Cargo;
use Cat\Models\Contrato;
use Cat\Models\Domicilio;
use Cat\Models\EstadoContrato;
use Cat\Models\Estudio;
use Cat\Models\Funcion;
use Cat\Models\Gerencia;
use Cat\Models\Operativo;
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

class ModificacionHandler extends ExcelHandler
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
                if ($row->cuit !== 'empty') {
                    /** @var Agente $model */
                    try {
                        $model = Agente::where('cuit', '=', $row->cuit)->firstOrFail();
                    } catch (ModelNotFoundException $exception) {
                        $model = Agente::create($row->toArray());
                    }
                    
                    $this->handlePersonales($model, $row)
                        ->handleLaborales($model, $row)
                        ->handleOperativos($model, $row);
                    Log::info('Se realizo el cambio con cuit final: ' . $row->cuit);
                } else {
                    break;
                }
            } catch (\Exception $e) {
                Log::error($e);
                
                $listaErrores[] = [
                    '#'           => $i + 2,
                    'nombre'      => $row->nombre,
                    'apellido'    => $row->apellido,
                    'dni'         => $row->dni,
                    'cuit'        => $row->cuit,
                    'mensaje'     => 'Los datos provistos no se han podido procesar, por favor reviselos e intente nuevamente',
                    'tech_reason' => $e->getMessage(),
                ];
            }
        }
        
        
        $fileErrores->sheet('Errores', function ($sheet) use ($listaErrores) {
            
            $sheet->fromArray($listaErrores);
            
        })->store('xls', $this->location, true);
        
        Flash::warning('Se finaliz&oacute; el proceso de importaci&oacute;n');
        
    }
    
    private function handlePersonales(Agente $model, CellCollection $row)
    {
        // Instancia sin DB
        $agente = PersonalesMapper::toAgenteInput($row);
        
        $model->update($agente);
        
        $domicilio = [
            
            'calle'        => DataCleaner::cleanPossibleEmptyValue($row->domicilio_calle),
            'numero'       => DataCleaner::cleanPossibleEmptyValue($row->domicilio_numero),
            'departamento' => DataCleaner::cleanPossibleEmptyValue($row->domicilio_departamento),
            'piso'         => DataCleaner::cleanPossibleEmptyValue($row->domicilio_piso),
            'barrio'       => DataCleaner::cleanPossibleEmptyValue($row->domicilio_barrio),
            'provincia'    => DataCleaner::cleanPossibleEmptyValue($row->domicilio_provincia),
            'constituido'  => (bool)DataCleaner::cleanPossibleEmptyValue((strtoupper($row->domicilio_constituido) == 'SI') ? true : false),
            'libre'        => DataCleaner::cleanPossibleEmptyValue($row->domicilio_otro),
            'id_agente'    => $model->id,
        ];
        
        Domicilio::create($domicilio);
        
        $estudio = [
            'carrera'     => DataCleaner::cleanPossibleEmptyValue($row->estudio_carrera),
            'institucion' => DataCleaner::cleanPossibleEmptyValue($row->estudio_institucion),
            'estado'      => DataCleaner::cleanPossibleEmptyValue($row->estudio_estado),
            'nivel'       => DataCleaner::cleanPossibleEmptyValue($row->estudio_nivel),
            'id_agente'   => $model->id,
        
        ];
        
        Estudio::create($estudio);
        
        return $this;
    }
    
    
    private function handleLaborales(Agente $agente, CellCollection $collection)
    {
        
        
        if (DataCleaner::cleanPossibleEmptyValue($collection->id_sial)) {
            $laboral['id_sial'] = DataCleaner::cleanPossibleEmptyValue($collection->id_sial);
        }
        if (DataCleaner::cleanPossibleEmptyValue($collection->ficha)) {
            $laboral['ficha'] = DataCleaner::cleanPossibleEmptyValue($collection->ficha);
        }
        if (DataCleaner::cleanPossibleEmptyDate($collection->fecha_ingreso)) {
            $laboral['fecha_ingreso'] = DataCleaner::cleanPossibleEmptyDate($collection->fecha_ingreso);
        }
        if (DataCleaner::cleanPossibleEmptyDate($collection->fecha_ingreso_gobierno)) {
            $laboral['fecha_ingreso_gobierno'] = DataCleaner::cleanPossibleEmptyDate($collection->fecha_ingreso_gobierno);
        }
        if (DataCleaner::cleanPossibleEmptyValue($collection->tipo_inscripcion)) {
            $laboral['tipo_inscripcion'] = DataCleaner::cleanPossibleEmptyValue($collection->tipo_inscripcion);
        }
        if (DataCleaner::cleanPossibleEmptyValue($collection->monto)) {
            $laboral['monto'] = DataCleaner::cleanPossibleEmptyValue($collection->monto);
        }
        
        if (DataCleaner::cleanPossibleEmptyValue($collection->estado_contrato)) {
            
            try {
                $estadoContrato                = EstadoContrato::findOrFail(DataCleaner::cleanPossibleEmptyValue($collection->estado_contrato,
                    true));
                $laboral['id_estado_contrato'] = $estadoContrato->id;
            } catch (ModelNotFoundException $e) {
            }
        }
        
        if (DataCleaner::cleanPossibleEmptyValue($collection->modalidad_contractual)) {
            try {
                $modalidad                   = TipoContrato::findOrFail(DataCleaner::cleanPossibleEmptyValue($collection->modalidad_contractual,
                    true));
                $laboral['id_tipo_contrato'] = $modalidad->id;
            } catch (ModelNotFoundException $e) {
            }
        }
        
        try {
            $agente->contrato()->firstOrFail()->update($laboral);
        } catch (ModelNotFoundException $e) {
            $laboral['id_agente'] = $agente->id;
            Contrato::create($laboral);
        }
        
        return $this;
    }
    
    private function handleOperativos(Agente $agente, CellCollection $collection)
    {
        $operativo = [];
        try {
            $base                 = Base::where('nombre', '=', $collection->base)->firstOrFail();
            $operativo['id_base'] = $base->id;
        } catch (ModelNotFoundException $e) {
        }
        
        /**
         * Opcionales
         */
        $subGerencia = Gerencia::find(DataCleaner::cleanPossibleEmptyValue($collection->subgerencia, true));
        
        if ($subGerencia == null) {
            $subGerencia = Gerencia::find(DataCleaner::cleanPossibleEmptyValue($collection->gerencia, true));
            if ($subGerencia) {
                $operativo['id_gerencia'] = $subGerencia->id;
            }
        }
        
        
        $operativo['id_agente'] = $agente->id;
        
        if (DataCleaner::cleanPossibleEmptyValue($collection->area)) {
            
            try {
                $area                 = Area::findOrFail(DataCleaner::cleanPossibleEmptyValue($collection->area, true));
                $operativo['id_area'] = $area->id;
            } catch (ModelNotFoundException $e) {
            }
        }
        if (DataCleaner::cleanPossibleEmptyValue($collection->cargo)) {
            try {
                $cargo = Cargo::firsOrFail(DataCleaner::cleanPossibleEmptyValue($collection->cargo, true));
                
                $operativo['id_cargo'] = $cargo->id;
            } catch (ModelNotFoundException $e) {
            }
        }
        if (DataCleaner::cleanPossibleEmptyValue($collection->funcion)) {
            try {
                $funcion = Funcion::firstOrFail(DataCleaner::cleanPossibleEmptyValue($collection->funcion, true));
                
                $operativo['id_funcion'] = $funcion->id;
            } catch (ModelNotFoundException $e) {
            }
        }
        if (DataCleaner::cleanPossibleEmptyValue($collection->turno)) {
            try {
                $turno = Turno::firstOrfail(DataCleaner::cleanPossibleEmptyValue($collection->turno, true));
                
                $operativo['id_turno'] = $turno->id;
            } catch (ModelNotFoundException $e) {
            }
        }
        if (DataCleaner::cleanPossibleEmptyValue($collection->funcion_especifica)) {
            $operativo['funcion_especifica'] = DataCleaner::cleanPossibleEmptyValue($collection->funcion_especifica);
        }
        if (DataCleaner::cleanPossibleEmptyValue($collection->hora_entrada)) {
            $operativo['hora_entrada'] = DataCleaner::cleanPossibleEmptyValue($collection->hora_entrada);
        }
        if (DataCleaner::cleanPossibleEmptyValue($collection->hora_salida)) {
            $operativo['hora_salida'] = DataCleaner::cleanPossibleEmptyValue($collection->hora_salida);
        }
        if ((int)DataCleaner::cleanPossibleEmptyValue($collection->eximido)) {
            $operativo['eximido'] = (int)DataCleaner::cleanPossibleEmptyValue($collection->eximido);
        }
        if ((int)DataCleaner::cleanPossibleEmptyValue($collection->rotativo)) {
            $operativo['rotativo'] = (int)DataCleaner::cleanPossibleEmptyValue($collection->rotativo);
        }
        
        try {
            $agente->operativo()->firstOrFail()->update($operativo);
        } catch (ModelNotFoundException $e) {
            $operativo['id_agente'] = $agente->id;
            try {
                Operativo::create($operativo);
            } catch (\Exception $exception) {
            }
        }
        
        return $this;
    }
    
}