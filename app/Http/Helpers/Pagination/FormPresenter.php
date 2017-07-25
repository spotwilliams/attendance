<?php

namespace Cat\Helpers\Pagination;

use Illuminate\Pagination\BootstrapThreeNextPreviousButtonRendererTrait;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\Presenter as PresenterContract;

class FormPresenter implements PresenterContract
{
    use BootstrapThreeNextPreviousButtonRendererTrait;
    
    /**
     * The paginator implementation.
     *
     * @var \Illuminate\Contracts\Pagination\Paginator
     */
    protected $paginator;
    
    /**
     * The URL window data structure.
     *
     * @var array
     */
    protected $window;
    
    /**
     * The name of the route
     * @var  string
     */
    protected $route;
    
    /**
     * The params to create input
     * @var array
     */
    protected $params;
    
    /**
     * Create a new Bootstrap presenter instance.
     *
     * @param  \Illuminate\Contracts\Pagination\Paginator $paginator
     * @param  \Illuminate\Pagination\UrlWindow|null $window
     */
    public function __construct(PaginatorContract $paginator, $route, UrlWindow $window = null)
    {
        $this->paginator = $paginator;
        $this->route     = $route;
        $this->window    = is_null($window) ? UrlWindow::make($paginator) : $window->get();
    }
    
    public function setRoute($routeName)
    {
        $this->route = $routeName;
    }
    
    
    public function setInputsParams($params)
    {
        $this->params = $params;
    }
    
    /**
     * Determine if the underlying paginator being presented has pages to show.
     *
     * @return bool
     */
    public function hasPages()
    {
        return $this->paginator->hasPages();
    }
    
    /**
     * Convert the URL window into Bootstrap HTML.
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function render()
    {
        if ($this->hasPages()) {
            return new HtmlString(sprintf(
                '<ul class="pagination">%s %s %s</ul>',
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
            ));
        }
        
        return '';
    }
    
    
    protected function getHtmlForm($url, $page)
    {
        unset($this->params['page']);
        $html = '<form method="post" action="' . $url . '">';
        
        $html .= '<input type="submit" name="page" value="' . $page . '" class="btn btn-default" ' . (($page === $this->paginator->currentPage() ? ' disabled ' : '')) . '/>';
        foreach ($this->params as $name => $value) {
            if (!is_array($value)) {
                $html .= '<input type="hidden" name="' . $name . '" value="' . $value . '" />';
            } else {
                foreach ($value as $option) {
                    $html .= '<input type="hidden" name="' . $name . '[]" value="' . $option . '" />';
                }
            }
        }
        
        $html .= '</form>';
        
        return $html;
    }
    
    /**
     * Get HTML wrapper for an available page link.
     *
     * @param  string $url
     * @param  int $page
     * @param  string|null $rel
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel = is_null($rel) ? '' : ' rel="' . $rel . '"';
        
        return '<li><a href="' . htmlentities($url) . '"' . $rel . '>' . $page . '</a></li>';
    }
    
    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<li class="disabled"><span>' . $text . '</span></li>';
    }
    
    
    /**
     * Get a pagination "dot" element.
     *
     * @return string
     */
    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');
    }
    
    
    /**
     * Get the last page from the paginator.
     *
     * @return int
     */
    protected function lastPage()
    {
        return $this->paginator->lastPage();
    }
    
    protected function getLinks()
    {
        $forms        = [];
        $htmlComplete = '';
        
        foreach ($this->window['first'] as $page => $url) {
            $forms [] = $this->getHtmlForm(route($this->route), $page);
        }
        
        
        if (is_array($this->window['slider'])) {
            $forms[] = $this->getDots();
            foreach ($this->window['slider'] as $page => $url) {
                $forms [] = $this->getHtmlForm(route($this->route), $page);
            }
        }
        
        if (is_array($this->window['last'])) {
            $forms[] = $this->getDots();
            foreach ($this->window['last'] as $page => $url) {
                $forms [] = $this->getHtmlForm(route($this->route), $page);
            }
        }
        
        foreach ($forms as $html) {
            $htmlComplete .= '<li>' . $html . '</li>';
        }
        
        return $htmlComplete;
    }
    
    /**
     * Get HTML wrapper for a page link.
     *
     * @param  string $url
     * @param  int $page
     * @param  string|null $rel
     * @return string
     */
    protected function getPageLinkWrapper($url, $page, $rel = null)
    {
        if ($page == $this->paginator->currentPage()) {
            return $this->getActivePageWrapper($page);
        }
        
        return $this->getAvailablePageWrapper($url, $page, $rel);
    }
    
}
