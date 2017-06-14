@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Datos del agente
        </h1>
    </section>
    <div class="content">
        <div class="box box-warning">

            {{-- TABS --}}
            <div class="box-body">
                @include('flash::message')
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        @if($tab === 'personales')
                            <li class="active">
                                <a href="#personales" data-toggle="tab" aria-expanded="true">Personales</a>
                            </li>
                        @else
                            <li class="disabled">
                                <a>Personales</a>
                            </li>
                        @endif
                        @if($tab === 'laborales')
                            <li class="active">
                                <a href="#laborales" data-toggle="tab" aria-expanded="true">Laborales</a>
                            </li>
                        @else
                            <li class="disabled">
                                <a>Laborales</a>
                            </li>
                        @endif
                        @if($tab === 'operativos')
                            <li class="active">
                                <a href="#operativos" data-toggle="tab" aria-expanded="true">Operativos</a>
                            </li>
                        @else
                            <li class="disabled">
                                <a>Operativos</a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        {{--

                        Errores generales

                        --}}
                        @if($errors->has('operacion'))
                            <ul class="alert alert-danger" style="list-style-type: none">
                                <li>{!! $errors->first('operacion') !!}</li>
                            </ul>
                        @endif

                        {{-- PERSONALES --}}

                        @if($tab === 'personales')
                            <div class="tab-pane  active" id="personales">
                                {!! Form::model($agente, ['route' => ['agentesUpdatePersonales'], 'method' => 'post', 'class' => 'form-horizontal']) !!}
                                @include('Agentes::registro.forms.form-personales')
                                {!! Form::close() !!}
                            </div>
                        @endif
                        {{-- LABORALES --}}
                        @if($tab === 'laborales')
                            <div class="tab-pane active" id="laborales">
                                {!! Form::model($contrato, ['route' => ['agentesUpdateLaborales'], 'method' => 'post', 'class' => 'form-horizontal']) !!}
                                @include('Agentes::registro.forms.form-laborales')
                                {!! Form::close() !!}
                            </div>
                        @endif
                        {{-- OPERATIVOS --}}
                        @if($tab === 'operativos')
                            <div class="tab-pane active" id="operativos">
                                {!! Form::model($operativo, ['route' => ['agentesUpdateOperativos'], 'method' => 'post', 'class' => 'form-horizontal']) !!}
                                @include('Agentes::registro.forms.form-operativos')
                                {!! Form::close() !!}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

