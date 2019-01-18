@extends('layouts.app')

@section('content')

    <section class="content">
        <div class="row"
        >
            <div class="col-md-6">
                @include('parts.imagen')
            </div>
            <div class="col-md-6">
                <div class="row">

                    @include('parts.resumen')
                </div>
            </div>
        </div>
        <br>

        @include('parts.grafico')

    </section>
@endsection
