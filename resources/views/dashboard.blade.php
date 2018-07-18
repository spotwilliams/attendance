@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Cuerpo de agentes de tr&aacute;nsito
            <small>CABA</small>
        </h1>
    </section>
    <section class="content">
        @include('parts.resumen')

        @include('parts.grafico')

    </section>
@endsection
