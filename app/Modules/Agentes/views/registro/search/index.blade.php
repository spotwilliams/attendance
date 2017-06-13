@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de agentes</h3>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        {{ Form::open(['route' => 'agentesSearchIndex', 'method' => 'GET'])}}
                        <div class="input-group input-group-sm">
                            {{--<input type="text" class="form-control">--}}
                            {{ Form::text('search', Request::input('search'), ['id' => 'search', 'placeholder' => 'Ingrese un nombre ó CUIT ó DNI...', 'class' => 'form-control']) }}
                            <span class="input-group-btn">
                                {{--<button type="button" class="btn btn-info btn-flat">Buscar!</button>--}}
                                {{ Form::submit('Buscar', ['class' => 'btn btn-info btn-flat']) }}
                            </span>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <hr/>
                    {{--<div class="col-md-2 col-xs-2">--}}
                        {{--<div>--}}
{{----}}
                            {{--@include('Agentes::registro.search.filter')--}}
                        {{--</div>--}}
{{----}}
                    {{--</div>--}}
                    <div class="col-md-12 col-xs-12">

                        <table class="table table-hover">

                            <thead>
                            <th>Agente</th>
                            <th>DNI</th>
                            <th>CUIT</th>
                            <th>Base</th>
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

