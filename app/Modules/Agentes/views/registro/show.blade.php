@extends('layouts.app')

@section('content')
    <?php

    try {
        /** @var \Cat\Models\Agente $agente */
        $base = $agente->base();
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        $base = new \Cat\Models\Base();
    }
    ?>
    <section class="content-header">
        <h1>
            Datos del personal
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

                        <h3 class="profile-username text-center">{{$agente->apellido}}, {{$agente->nombre}}</h3>

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
                            <li class="list-group-item">
                                <b>Sexo</b><a class="pull-right">

                                    {{($agente->sexo === ''?'':($agente->sexo ==='F'? 'Femenimo': 'Masculino'))}}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="box-body">
                    <a href="{!! route('agentesIndex', ['base' => $base->id]) !!}"
                       class="btn btn-primary">Volver</a>
                    <a href="{{route('agentesEditPersonales', ['id' => $agente->id])}}"
                       class="btn btn-primary"
                       data-toggle="tooltip" data-placement="top" title="Editar"
                    >Editar
                        <i class="fa fa-edit"></i>
                    </a>
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
            @include('Agentes::registro.show.tabs')

            <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
    </section>

@endsection
