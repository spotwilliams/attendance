<?php


?>

<h4 class="control-sidebar-heading">Referencia de licencias</h4>
<ul class="list-unstyled clearfix">
    @foreach(\Cat\Repositories\TipoPresentismosRepository::getAll()->groupBy('aplica') as $aplicaCode=> $aplica)
        <label style="width: 100%">@lang('aplica.'.$aplicaCode)</label>
        @foreach($aplica as $tipo)


            <li style="float:left; width: 33.33333%; padding: 5px;" data-toggle="tooltip" data-placement="left" title="{{$tipo->descripcion}}">
                <span class="label"
                      style="background-color: {{$tipo->color}}; font: {{$tipo->color_letra}}"
                >{{$tipo->codigo}}</span>
            </li>
        @endforeach
    @endforeach
</ul>


