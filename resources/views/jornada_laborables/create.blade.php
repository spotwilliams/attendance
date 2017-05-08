@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Jornada Laborable
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'jornadaLaborables.store']) !!}

                        @include('jornada_laborables.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
