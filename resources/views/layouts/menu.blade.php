<?php ?>

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
        {{--@haspermission('Buscar personal')--}}
        <li>

            <a href="{{route('agentesCreatePersonales')}}">
                <i class="fa fa-edit"></i>
                <span>Alta individual</span>
            </a>
        </li>
        {{--@endhaspermission--}}
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
        <li>
            <a href="{!! route('presentismoPorAgenteIndex') !!}">
                <i class="fa fa-user"></i>
                <span>Registro por agente</span>
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
            <a href="{!! route('haberesIndex') !!}">
                <i class="fa fa-money"></i>
                <span>Registro de facturas</span>
            </a>
        </li>
        <li>
            <a href="{!! route('modificacionMasivaContratosIndex') !!}">
                <i class="fa fa-file-text-o"></i>
                <span>Modificaci&oacute;n masiva de contratos</span>
            </a>
        </li>
    </ul>
</li>

<li class="dropdown {{ Request::is('reportes*') ? 'active' : '' }}">
    <a href="#"
       class="dropdown-toggle"
       data-toggle="dropdown"
       aria-expanded="true"
    >
        <i class="fa fa-bar-chart"></i>
        <span>Reportes</span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li>
            <a href="{!! route('reportesPresentismoGeneralIndex') !!}">
                <i class="fa fa-check"></i>
                <span>Presentismo</span>
            </a>
        </li>
        <li>
            <a href="{!! route('reportesAgentesGeneralIndex') !!}">
                <i class="fa fa-user-secret"></i>
                <span>Datos personales</span>
            </a>
        </li>
        <li>
            <a href="{!! route('reportesPresentismoIndividualIndex') !!}">
                <i class="fa fa-calendar"></i>
                <span>Licencias</span>
            </a>
        </li>
        <li class="divider"></li>
        <li>
            <a href="{!! route('reportesHaberesVistaPreviaIndex') !!}">
                <i class="fa fa-search"></i>
                <span>Control de base</span>
            </a>
        </li>
        <li>
            <a href="{!! route('reportesHaberesEstadoIndex') !!}">
                <i class="fa fa-money"></i>
                <span>Res&uacute;men de haberes</span>
            </a>
        </li>
        <li>
            <a href="{!! route('reportesHaberesAgentesIndex') !!}">
                <i class="fa fa-money"></i>
                <span>Res&uacute;men de haberes por persona</span>
            </a>
        </li>
    </ul>
</li>

<li class="dropdown {{ Request::is('configuracion*') ? 'active' : '' }}">
    <a href="#"
       class="dropdown-toggle"
       data-toggle="dropdown"
       aria-expanded="true"
    >
        <i class="fa fa-gears"></i>
        <span>Configuraci&oacute;n</span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">
        <li class="divider"></li>
        <li>
            <a href="{!! route('configuracion.base.index') !!}">
                <i class="fa fa-building"></i>
                <span>Bases</span>
            </a>
        </li>
        <li>
            <a href="{!! route('configuracion.area.index') !!}">
                <i class="fa fa-map"></i>
                <span>Areas</span>
            </a>
        </li>
        <li>
            <a href="{!! route('configuracion.turno.index') !!}">
                <i class="fa fa-clock-o"></i>
                <span>Turnos</span>
            </a>
        </li>
        <li>
            <a href="{!! route('configuracion.licencia.index') !!}">
                <i class="fa fa-calendar"></i>
                <span>Tipos licencias</span>
            </a>
        </li>
        <li class="divider"></li>
        {{--<li>--}}
        {{--<a href="#">--}}
        {{--<span class="label label-warning">Usuarios y roles</span>--}}
        {{--</a>--}}
        {{--</li>--}}

        <li>
            <a href="{{ route('seguridad.usuario.index') }}"><i class="fa fa-user"></i>
                <span>Usuarios</span></a>
        </li>
        <li>
            <a href="{{ route('seguridad.rol.index') }}"><i class="fa fa-group"></i>
                <span>Roles</span></a>
        </li>
        <li>
            <a href="{{ route('seguridad.permission.index') }}"><i class="fa fa-lock"></i>
                <span>Permisos</span></a>
        </li>


    </ul>
</li>


