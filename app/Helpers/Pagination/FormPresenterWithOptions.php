<?php

namespace Cat\Helpers\Pagination;

class FormPresenterWithOptions extends FormPresenter
{
    
    public function renderOne($text, $options = [])
    {
        return $this->getHtmlForm(route($this->route), $text, $options);
    }
    
    
    protected function getHtmlForm($url, $text, $options = [])
    {
        unset($this->params['page']);
        $html = '<form method="post" action="' . $url . '" class="form-horizontal">';
        
        $html .= $this->getButtonWithOptions($text, $options);
        
        $html .= '<input type="hidden" name="_token" value="' . csrf_token() . '" />';
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
    
    protected function getButtonWithOptions($text, $options = [])
    {
        $li = '';
        foreach ($options as $input) {
            $li .= "<li><a href='#'><input type='checkbox' name='{$input['name']}' /> {$input['text']}</a></li>";
        }
        
        $html
            = "<div class='btn-group'>
                  <button type='submit' class='btn btn-default'>$text</button>
                  <button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown'>
                    <span class='fa fa-gears'></span>
                    <span class='sr-only'>Toggle Dropdown</span>
                  </button>
                  <ul class='dropdown-menu' role='menu'>
                    $li
                  </ul>
                </div>";
        
        
        return $html;
        
    }
    
}
