@extends('layouts.app')

@section('content')
    <div class="content">

        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">B&uacute;squeda de personal</h3>
            </div>
            <div class="box-body">


                <div class="row">
                    <div class="col-md-10 col-xs-10">
                        <form action="{{ route('agentesSearchIndex') }}" method="GET">@csrf
                        <div class="col-md-4">
                            <input type="text" name="apellido" id="apellido" value="{{ old('apellido', Request::input('apellido')) }}" placeholder="Apellido" class="col-md-3 form-control">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', Request::input('nombre')) }}" placeholder="Nombre" class="col-md-3 form-control">
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <?php
                                $cuitsInputs = '';
                                if (\Illuminate\Support\Facades\Request::input('cuit')) {

                                    $cuitsInputs = is_array(\Illuminate\Support\Facades\Request::input('cuit')) ? implode(',',
                                        \Illuminate\Support\Facades\Request::input('cuit')) : \Illuminate\Support\Facades\Request::input('cuit');
                                }
                                ?>
                                <input type="text" name="cuit" value="{{$cuitsInputs}}" class="form-control">
                                <span class="input-group-btn">
                                <button type="submit" class="btn btn-info btn-flat">Buscar</button>
                            </span>
                            </div>
                        </div>
                        </form>

                    </div>
                    <div class="col-md-2 col-xs-2">
                        @include('Agentes::registro.commons.nuevo-btn')
                    </div>
                    <br>
                    <br>
                    <div class="col-md-12 col-xs-12">

                        <table class="table table-hover">

                            <thead>
                            <th>Personal</th>
                            {{--<th>DNI</th>--}}
                            <th>CUIT</th>
                            <th>Base</th>
                            <th>Operaciones</th>
                            </thead>
                            <tbody>
                            @include('Agentes::registro.search.rows')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-6 col-md-offset-3">
                    {{$agentes->links()}}
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('input[name="cuit"].form-control').tokenfield();
        })
    </script>
@append
