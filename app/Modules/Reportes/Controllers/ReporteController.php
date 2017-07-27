<?php

namespace Cat\Modules\Reportes\Controllers;



use Cat\Helpers\Pagination\FormPresenter;
use Cat\Http\Controllers\AppBaseController;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class ReporteController extends AppBaseController
{
    /** @var  Builder */
    protected $query;
    
    /** @var  int */
    protected $page;
    
    /**
     * Html handler for page links
     * @var FormPresenter
     */
    protected $presenter;
    
    public function __construct()
    {
        $this->middleware('auth');
        
    }
    
    abstract protected function setupParams(Request $request);
    
    abstract protected function setupQuery();
    
    protected function getLinksLikeForm(LengthAwarePaginator $paginator, Request $request)
    {
        /** @var FormPresenter $presenter */
        $presenter = new FormPresenter($paginator, 'reportesAgentesGeneralSearch');
        $presenter->setInputsParams($request->all());
        
        return $paginator->links($this->presenter);
    }
    
    protected function getExportForm(LengthAwarePaginator $paginator, Request $request, $route)
    {
        /** @var FormPresenter $presenter */
        $presenter = new FormPresenter($paginator, $route);
        $presenter->setInputsParams($request->all());
        
        return $presenter->renderOne('Exportar a excel');
    }
}