<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Models\Base;
use Cat\Models\Contrato;
use Cat\Models\Haber;
use Cat\Models\Periodo;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Cat\Modules\Haberes\Controllers\Helpers\Data;
use Cat\Modules\Haberes\Services\Reporte\Reporte;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Response;

class ReporteController extends AppBaseController
{
    
    /** @var  Data */
    private $helper;
    
    public function __construct(Data $helper)
    {
        $this->helper = $helper;
        $this->middleware('auth');
        
    }
    
    
    public function reporte(Request $request)
    {
        $input = $request->all();
        try {
            $periodo = Periodo::findOrFail($input['periodo']);
            $base    = Base::findOrFail($input['base']);
            $turno   = Turno::findOrFail($input['turno']);
            $agentes = $this->helper
                ->getAgentesForHaberesReport($base, $turno, $periodo);
            
            $service = new Reporte($agentes);
            
            $service->execute();
            
        } catch (\Exception $e) {

            Flash::error('No se ha podido continuar. Intente nuevamente');
            return view('Haberes::calculo.index-base');
        }
        
    }
}
