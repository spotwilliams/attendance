<?php

namespace Cat\Reportes\Controllers\Agentes;

use Cat\Helpers\Pagination\FormPresenter;
use Cat\Models\Agente;
use Cat\Http\Controllers\AppBaseController;
use Cat\Models\Base;
use Cat\Models\Cargo;
use Cat\Models\EstadoContrato;
use Cat\Models\Funcion;
use Cat\Models\Presentismo;
use Cat\Models\TipoContrato;
use Cat\Models\Turno;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;

class Exportar extends General
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the Presentismo.
     *
     * @param Request $request
     * @return Response
     */
    public function export(Request $request)
    {
        $this->setupParams($request)
            ->setupQuery();
        dd($this);
        return $this->query->get();
    }
}
