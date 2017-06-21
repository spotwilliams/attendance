<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#personales" data-toggle="tab" aria-expanded="true">Personales</a>
        </li>
        <li>
            <a href="#laborales" data-toggle="tab" aria-expanded="true">Laborales</a>
        </li>
        <li>
            <a href="#operativos" data-toggle="tab" aria-expanded="true">Operativos</a>
        </li>
    </ul>
    <div class="tab-content">
        @include('flash::message')
        {{-- PERSONALES --}}

        <div class="tab-pane active" id="personales">
            @include('Agentes::registro.show.personales')
        </div>
        {{-- LABORALES --}}
        <div class="tab-pane" id="laborales">
            @include('Agentes::registro.show.laborales')
        </div>
        {{-- OPERATIVOS --}}
        <div class="tab-pane" id="operativos">
            @include('Agentes::registro.show.operativos')
        </div>
    </div>
</div>
