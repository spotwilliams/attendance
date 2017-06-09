<?php

$idModal = 'comentarios-modal'
?>


@extends('layouts.app')

@section('content')

    <div class="content">

        <div class="clearfix"></div>
        @include('flash::message')

        <div class="clearfix"></div>

        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">C&aacute;lculo de haberes</h3>
            </div>

            <div class="box-body">
            @include('Presentismo::registro.table')
            </div>
            <div class="box-footer">
                <div class="col-md-6 col-md-offset-3">

                    {{$agentes->links()}}
                </div>

            </div>
        </div>
    </div>
    @include('parts.modal', ['idModal' => $idModal, 'titleModal' => 'Comentarios para la fecha'])
@endsection
