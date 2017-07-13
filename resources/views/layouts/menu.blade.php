<li class="dropdown {{ Request::is('agentes*') ? 'active' : '' }}">
    <a href="#"
       class="dropdown-toggle"
       data-toggle="dropdown"
       aria-expanded="true"
    >
        <i class="fa fa-user-secret"></i>

        <span>Personal</span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{!! route('agentesSearchIndex') !!}">
                <i class="fa fa-search"></i>
                <span>B&uacute;squeda de personal</span>
            </a>
        </li>
        <li>
            <a href="{!! route('agentesIndex', ['base' => 1]) !!}">
                <i class="fa fa-list"></i>
                <span>Lista de personal por base</span>
            </a>
        </li>
        <li>

            <a href="{{route('agentesCreatePersonales')}}">
                <i class="fa fa-edit"></i>
                <span>Alta individual</span>
            </a>
        </li>
        <li>
            <a href="{!! route('agentesMasivoIndex') !!}">
                <i class="fa fa-file-excel-o"></i>
                <span>Alta masiva</span>
            </a>
        </li>
    </ul>
</li>


<li class="dropdown {{ Request::is('presentismo*') ? 'active' : '' }}">
    <a href="#"
       class="dropdown-toggle"
       data-toggle="dropdown"
       aria-expanded="true"
    >
        <i class="fa fa-calendar"></i>
        <span>Presentismo</span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{!! route('presentismoIndex') !!}">
                <i class="fa fa-edit"></i>
                <span>Registro manual</span>
            </a>
        </li>
        <li>
            <a href="{!! route('presentismosMasivoIndex') !!}">
                <i class="fa fa-file-excel-o"></i>
                <span>Registro masivo</span>
            </a>
        </li>

    </ul>
</li>

<li class="dropdown {{ Request::is('administracion*') ? 'active' : '' }}">
    <a href="#"
       class="dropdown-toggle"
       data-toggle="dropdown"
       aria-expanded="true"
    >
        <i class="fa fa-edit"></i>
        <span>Administraci&oacute;n</span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{!! route('haberesSelectBase') !!}">
                <i class="fa fa-money"></i>
                <span>C&aacute;lculo de haberes</span>
            </a>
        </li>
    </ul>
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

