@extends('layouts.app')

@section('content')


    <section class="content">

        <div class="error-page">
            <div class="error-content">
                <h1><i class="fa fa-warning text-warning"></i>No era por aqu&iacute;!</h1>
                <p class="lead">Por favor, utilice el men&uacute; para ir hacia la secci&oacute;n deseada
                </p>
            </div>

        </div>
        @include('flash::message')

    </section>
@endsection