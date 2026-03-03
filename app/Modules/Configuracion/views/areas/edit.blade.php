@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Area
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <form action="{{ route('configuracion.area.update', $area->id) }}" method="POST">@csrf @method('PATCH')

                    @include('Configuracion::areas.fields')

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection