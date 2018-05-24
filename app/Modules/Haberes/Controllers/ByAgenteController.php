<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Helpers\Pagination\FormPresenter;
use Cat\Models\Base;
use Cat\Models\Contrato;
use Cat\Models\EstadoPeriodo;
use Cat\Models\Haber;
use Cat\Models\Operativo;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Cat\Modules\Agentes\Controllers\Registro\BusquedaController;
use Cat\Modules\Validation\Repositories\PresentismoRepository;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Laracasts\Flash\Flash;

class ByAgenteController extends BusquedaController
{
    public function search(Request $request)
    {
        /** @var View $result */
        $result = parent::search($request);
        /** @var LengthAwarePaginator $agentes */
        $agentes = $result->getData()['agentes'];
        
        return view('Haberes::calculo.index')
            ->with('agentes', $agentes)
            ->with('links', $this->getLinks($agentes, $request));
    }
    
    private function getLinks(LengthAwarePaginator $agentes, Request $request)
    {
        $presenter = new FormPresenter($agentes, 'haberesSearchByAgente');
        $presenter->setInputsParams($request->all());
        
        return $agentes->links($presenter);
    }
    
}
