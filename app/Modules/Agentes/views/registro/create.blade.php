@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-warning">

            {{--

            TABS

            --}}
            <div class="box-body">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Datos del personal
                    </h3>
                </div>
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

                        {{--
                        PERSONALES
                        --}}

                        @if($tab === 'personales')
                            <div class="tab-pane  active" id="personales">
                                <form action="{{ route('agentesStorePersonales') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">@csrf
                                    @include('Agentes::registro.forms.form-personales')
                                </form>
                            </div>
                        @endif
                        {{-- LABORALES --}}
                        @if($tab === 'laborales')
                            <div class="tab-pane active" id="laborales">
                                <form action="{{ route('agentesStoreLaborales') }}" method="POST" class="form-horizontal">@csrf
                                    @include('Agentes::registro.forms.form-laborales')
                                </form>
                            </div>
                        @endif
                        {{-- OPERATIVOS --}}
                        @if($tab === 'operativos')
                            <div class="tab-pane active" id="operativos">
                                <form action="{{ route('agentesStoreOperativos') }}" method="POST" class="form-horizontal">@csrf
                                    @include('Agentes::registro.forms.form-operativos')
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
