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
                {{ Form::open(['route' => 'agentesSearchIndex', 'method' => 'GET', 'id' => 's-form',])}}
                {{ Form::text('search', null, ['id' => 'search', 'placeholder' => 'Search For ...']) }}
                {{ Form::submit('Go') }}
                {{ Form::close() }}
                <table class="display" id="presentismos-table">
                    <thead>
                    <th>Id Agente</th>
                    <th>Agente</th>
                    <th>CUIT</th>
                    <th>Operaciones</th>
                    </thead>
                    <tbody>
                    @include('Agentes::registro.search.rows')
                    </tbody>
                </table>
            </div>
            <div class="box-footer">
                <div class="col-md-6 col-md-offset-3">
                    {{$agentes->links()}}
                </div>

            </div>
        </div>
    </div>
@endsection

