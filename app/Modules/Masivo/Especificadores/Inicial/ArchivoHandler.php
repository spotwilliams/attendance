<?php

namespace Cat\Masivo\Especificadores\Inicial;

//use Cat\Masivo\Especificadores\Archivo;
use Cat\Models\Agente;
use Cat\Models\Presentismo;
use Cat\Models\TipoPresentismo;
use Cat\Modules\Presentismo\Services\Registro\Justificar;
use Cat\Modules\Presentismo\Services\Registro\Registro;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Laracasts\Flash\Flash;
use Maatwebsite\Excel\Collections\CellCollection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Files\ImportHandler;
use Maatwebsite\Excel\Writers\LaravelExcelWriter;
use Cat\Modules\Presentismo\Services\Helpers\Facilitador as StoreService;

class ArchivoHandler implements ImportHandler
{
    /** @var TipoPresentismo */
    protected $tipoPresentismo;
    /** @var  string */
    protected $location;
    
    public function __construct(TipoPresentismo $tipo, $locationStorage)
    {
        $this->tipoPresentismo = $tipo;
        $this->location        = $locationStorage;
    }
    
    /**
     * @param $inputFileName
     * @param $prefix Prefijo para guardar en sesion
     * @return mixed
     */
    protected function generateOutFile($inputFileName, $prefix)
    {
        $name = str_replace('.csv', '', $inputFileName) . '_errores';
        session()->flash($prefix . '_new_file', $this->location . $name . '.xls');
        
        return Excel::create($name);
        
    }
    
    protected function getSheet($file, $title)
    {
        $sheets = $file->all();
        foreach ($sheets as $sheet) {
            if ($sheet->getTitle() === $title) {
                return $sheet;
            }
        }
        throw new \Exception('No existe la hoja solicitada');
    }
    
    /**
     * @param $file Archivo
     * @return mixed
     */
    public function handle($file)
    {
        /** @var Archivo $file */
        $file->noHeading();
        $file->formatDates(false);
        
        $listaErrores = [];
        
        
        /** @var LaravelExcelWriter $fileErrores */
        $fileErrores = $this->generateOutFile($file->getFileName(), 'presentismos');
        
        
        /** @var RowCollection $sheet */
        $sheet = $this->getSheet($file, 'procesado');
        
        for ($i = 0; $i < $sheet->count(); $i++) {
            /** @var CellCollection $row */
            $row = $sheet->get($i);
            
            try {
                $agente = $this->getAgente($row);
                for ($j = 1; $j < $row->count(); $j++) {
                    if ($row->get($j) != null) {
                        $fecha = $row->get($j) . '-2017';
                        $date  = new \DateTime($fecha);
                        (new Registro($agente, $this->tipoPresentismo, $date))->execute();
                        $presentismo = Presentismo::where('id_agente', '=', $agente->id)
                            ->whereDate('fecha', '=', $date)
                            ->first();
                        (new Justificar($presentismo))->execute();
                        Log::info($agente->cuit . '-' . $fecha);
                    } else {
                        break;
                    }
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                $listaErrores[] = ['cuit' => $row->get(0), 'error' => $e->getMessage()];
            }
        }
        
        $fileErrores->sheet('Errores', function ($sheet) use ($listaErrores) {
            
            $sheet->fromArray($listaErrores);
            
        })->
        store('xls', $this->location, true);
        
        Flash::warning('Se finaliz&oacute; el proceso de importaci&oacute;n');
        
    }
    
    private function getAgente(CellCollection $row)
    {
        return Agente::where('cuit', '=', (string)round($row->get(0)))
            ->with('contrato.tipoContrato')
            ->firstOrFail();
    }
    
    
}