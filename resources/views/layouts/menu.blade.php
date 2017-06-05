<li class="dropdown {{ Request::is('agentes*') ? 'active' : '' }}">
    <a href="#"
       class="dropdown-toggle"
       data-toggle="dropdown"
       aria-expanded="true"
    >
        <i class="fa fa-user-secret"></i>

        <span>Agentes</span>
        <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{!! route('agentesIndex', ['base' => 1]) !!}">
                <i class="fa fa-edit"></i>
                <span>Individual</span>
            </a>
        </li>
        <li>
            <a href="{!! route('agentesMasivoIndex', ['base' => 1]) !!}">
                <i class="fa fa-file-excel-o"></i>
                <span>Alta Masiva</span>
            </a>
        </li>
    </ul>
</li>

<li class="{{ Request::is('presentismo*') ? 'active' : '' }}">
    <a href="{!! route('presentismoIndex', ['base' => 1]) !!}">
        <i class="fa fa-calendar"></i>
        <span>Presentismos</span>
    </a>
</li>
{{--<li class="{{ Request::is('areas*') ? 'active' : '' }}">--}}
{{--<a href="{!! route('areas.index') !!}"><i class="fa fa-edit"></i><span>Areas</span></a>--}}
{{--</li>--}}

{{--<li class="{{ Request::is('contratos*') ? 'active' : '' }}">--}}
{{--<a href="{!! route('contratos.index') !!}"><i class="fa fa-edit"></i><span>Contratos</span></a>--}}
{{--</li>--}}

{{--<li class="{{ Request::is('domicilios*') ? 'active' : '' }}">--}}
{{--<a href="{!! route('domicilios.index') !!}"><i class="fa fa-edit"></i><span>Domicilios</span></a>--}}
{{--</li>--}}


{{--<li class="{{ Request::is('diaDisponibles*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('diaDisponibles.index') !!}"><i class="fa fa-edit"></i><span>DiaDisponibles</span></a>--}}
{{--</li>--}}

{{--<li class="{{ Request::is('periodos*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('periodos.index') !!}"><i class="fa fa-edit"></i><span>Periodos</span></a>--}}
{{--</li>--}}

{{--<li class="{{ Request::is('baseModels*') ? 'active' : '' }}">--}}
    {{--<a href="{!! route('baseModels.index') !!}"><i class="fa fa-edit"></i><span>BaseModels</span></a>--}}
{{--</li>--}}

