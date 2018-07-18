@extends('layouts.app')

@section('content')


    <section class="content">

        <div class="error-page">
            <div class="error-content">
                <h1><i class="fa fa-ban text-danger"></i> Error de permisos</h1>
                <p class="lead">Usted no tiene permiso para acceder al recurso solicitado
                </p>
            </div>

        </div>
        @include('flash::message')

    </section>

@endsection