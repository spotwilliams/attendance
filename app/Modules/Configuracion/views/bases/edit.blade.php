@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Editar nombre de base
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <form action="{{ route('configuracion.base.update', $baseModel->id) }}" method="POST">@csrf @method('PATCH')

                    @include('Configuracion::bases.fields')

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection