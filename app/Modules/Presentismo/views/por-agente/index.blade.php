@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">B&uacute;squeda de personal para presentismo</h3>
            </div>
            <div class="box-body">

                <div class="row">
                    <div class="col-md-10 col-xs-10">
                        @include('Presentismo::por-agente.form')
                    </div>

                    <div class="col-md-12 col-xs-12">
                        @include('Presentismo::por-agente.table')
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="text-center">
                    @if(isset($links))
                        {!! $links !!}
                    @else
                        {{$agentes->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

