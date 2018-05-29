<?php

namespace Cat\Modules\Haberes\Controllers\Registro;

use Cat\Helpers\Pagination\FormPresenter;
use Cat\Modules\Agentes\Controllers\Registro\BusquedaController;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\View\View;
use Cat\Modules\Haberes\Controllers\Pageable;

class ByAgenteController extends BusquedaController
{
    use Pageable;
    
    
    /**
     * @param Request $request
     * @return $this|\Illuminate\Support\Facades\Response
     */
    public function search(Request $request)
    {
        /** @var View $result */
        parent::prepareQuery();
        /** @var LengthAwarePaginator $agentes */
        $agentes = $this->agentesEloquent->paginate($this->itemsPerPage);

        return view('Haberes::calculo.index')
            ->with('agentes', $agentes)
            ->with('links', $this->getLinks($agentes));
    }
    
    private function getLinks(LengthAwarePaginator $agentes)
    {
        $presenter = new FormPresenter($agentes, 'haberesSearchByAgente');
        $presenter->setInputsParams(['nombre' => $this->nombre, 'apellido' => $this->apellido, 'cuit' => Input::get('cuit')]);

        return $agentes->links($presenter);
    }
    
}
