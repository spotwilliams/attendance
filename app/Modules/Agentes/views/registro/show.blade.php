@extends('layouts.app')

@section('content')
    <?php

    /** @var \Cat\Models\Agente $agente */

    $base = $agente->base();
    ?>
    <section class="content-header">
        <h1>
            Datos del agente
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-warning">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{URL::asset('images/CABA1.png')}}"
                             alt="User profile picture">

                        <h3 class="profile-username text-center">{{$agente->nombre}}, {{$agente->apellido}}</h3>

                        <p class="text-muted text-center">Base: {{$base->nombre}}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>CUIT</b> <a class="pull-right">{{$agente->cuit}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>DNI</b> <a class="pull-right">{{$agente->dni}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Telefono</b> <a class="pull-right">{{$agente->telefono}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="pull-right">{{$agente->email}}</a>
                            </li>

                            <li class="list-group-item">
                                <b>F. Nacimiento</b> <a
                                        class="pull-right">{{(new DateTime($agente->fecha_nacimiento))->format('d/m/Y')}}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box-body">
                    <a href="{!! route('agentesIndex', ['base' => $base->id]) !!}"
                       class="btn btn-primary">Back</a>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#laborales" data-toggle="tab" aria-expanded="true">Laborales</a>
                        </li>
                        <li>
                            <a href="#operativos" data-toggle="tab" aria-expanded="true">Operativos</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @include('flash::message')
                        {{-- PERSONALES --}}

                        {{-- LABORALES --}}
                        <div class="tab-pane active" id="laborales">
                            @include('Agentes::registro.show.laborales')
                        </div>
                        {{-- OPERATIVOS --}}
                        <div class="tab-pane" id="operativos">
                            @include('Agentes::registro.show.operativos')
                        </div>
                    </div>
                </div>

                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
    </section>

@endsection
