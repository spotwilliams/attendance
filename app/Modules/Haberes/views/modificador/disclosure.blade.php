@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Modificaci&oacute;n contratos de Locaci&oacute;n</h3>
            </div>
            <div class="box-body">
                <div class="row">

                    <div class="col-md-12">
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-warning"></i> Aviso: Se van a realizar modificaciones masivas.</h4>
                            Usted va a modificar el monto de contrato de los agentes listados abajo, junto con su fecha
                            de
                            ingreso a la modalidad a la que pertenecen.
                            <br>
                            Estos cambios pueden revertirse de manera manual a trav&eacute;s de los datos del
                            personal
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="callout callout-success">
                            <h4>Listado de sectores seleccionadas</h4>
                            <ul>
                                @foreach($gerencias as $gerencia)
                                    <li>{{$gerencia->nombre}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="callout callout-success">
                            <h4>Nuevo monto</h4>
                            <p>$ {{$monto}}</p>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="callout callout-success">
                            <h4>Fecha de comienzo de contrato</h4>
                            <p>{{$fecha->format('d/m/Y')}}</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="row">
                    <br>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <table class="dataTable">
                            <thead>
                            <tr>
                                <th>Personal</th>
                                <th>CUIT</th>
                                <th>Base</th>
                                <th>Turno</th>
                                <th>Gerencia</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>

            <div class="box-footer">
                {!! Form::open(['route' => 'modificacionMasivaContratosUpdate', 'class'=>'form-horizontal', 'method' => 'POST']) !!}
                <input type="hidden" value="{{$monto}}" name="monto">
                <input type="hidden" value="{{$fecha->format('Y-m-d')}}" name="fecha_contrato">
                @foreach($gerencias as $gerencia)
                    <input type="hidden" value="{{$gerencia->id}}" name="gerencias[]">
                @endforeach
                <a href="{{URL::previous()}}" class="btn btn-default">Volver</a>
                <input type="submit"
                       class="btn btn-primary pull-right"
                       value='Finalizar'/>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

            var dataTable = $('.dataTable').DataTable({
                    data: {!!  $agentes->toJson()!!},
                    columns: [
                        {
                            data: function (agente) {
                                return agente.apellido + ', ' + agente.nombre;
                            }
                        },
                        {data: 'cuit'},
                        {data: 'operativo.base.nombre'},
                        {data: 'operativo.turno.codigo'},
                        {data: 'operativo.gerencia.nombre'}
                    ]
                })
            ;
            new $.fn.dataTable.FixedHeader(dataTable);
        })
    </script>
@append
