@extends('layouts.app')

@section('content')
    <?php

    /** @var \Cat\Models\Agente $agente */

    $base = $agente->base();
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-danger box-body">
                            <p class="help-block">
                                Para continuar, click en el bot&oacute;n.
                            </p>
                            <form action="{{ route('agentesDestroy') }}" method="POST" class="form-horizontal">@csrf
                            <input type="hidden" name="agente" value="{{ $agente->id }}">
                            <a class="btn btn-app bg-red"><i class="fa fa-trash"></i>Eliminar datos de personal</a>
                            </form>
                        </div>
                    </div>
                </div>
            @include('Agentes::registro.show.tabs')

            <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
    </section>
    <div class="modal modal-warning fade" id="modal-warning">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Cuidado</h4>
                </div>
                <div class="modal-body">
                    <p>Est&aacute;s a punto de elimiar la informaci&oacute;n de un personal. Esto provocar&aacute; que los datos
                    del mismo ya no sean accesibles.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>
                    <button type="button" id="okToGo" class="btn btn-danger"><i class="fa fa-trash-o"></i> Borrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.btn.btn-app.bg-red').on('click', function (obj, event) {
                $('#modal-warning').modal({});
            });

            $('#okToGo').on('click', function () {
                $('form').submit();
            })
        })
    </script>
@append
