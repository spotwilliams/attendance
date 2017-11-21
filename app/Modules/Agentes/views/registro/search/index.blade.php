@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">B&uacute;squeda de personal</h3>
            </div>
            <div class="box-body">


                <div class="row">
                    <div class="col-md-10 col-xs-10">
                        {{ Form::open(['route' => 'agentesSearchIndex', 'method' => 'GET'])}}
                        <div class="col-md-4">
                            {{ Form::text('apellido', Request::input('apellido'), ['id' => 'apellido', 'placeholder' => 'Apellido', 'class' => 'col-md-3 form-control']) }}
                        </div>
                        <div class="col-md-4">
                            {{ Form::text('nombre', Request::input('nombre'), ['id' => 'nombre', 'placeholder' => 'Nombre', 'class' => 'col-md-3 form-control']) }}
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                {{ Form::text('cuit', Request::input('cuit'), ['id' => 'cuit', 'placeholder' => 'CUIT', 'class' => 'form-control']) }}
                                <span class="input-group-btn">
                                {{ Form::submit('Buscar', ['class' => 'btn btn-info btn-flat']) }}
                            </span>
                            </div>
                        </div>
                        {{ Form::close() }}

                    </div>
                    <div class="col-md-2 col-xs-2">
                        @include('Agentes::registro.commons.nuevo-btn')
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12 col-xs-12">

                        <table class="table table-hover">

                            <thead>
                            <th>Personal</th>
                            {{--<th>DNI</th>--}}
                            <th>CUIT</th>
                            <th>Base</th>
                            <th>Operaciones</th>
                            </thead>
                            <tbody>
                            @include('Agentes::registro.search.rows')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-6 col-md-offset-3">
                    {{$agentes->links()}}
                </div>

            </div>
        </div>
    </div>
@endsection

