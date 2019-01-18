@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-6 text-center">
                @include('parts.imagen')
            </div>
            <div class="col-md-6">
                @include('parts.resumen')
            </div>

        </div>
    </section>
@endsection
