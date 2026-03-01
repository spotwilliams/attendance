@extends('layouts.app')


@section('content')

    <div class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <form action="{{ url($crud->route.'/'.$entry->getKey()) }}" method="POST">@csrf @method('PUT')
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar</h3>
                    </div>
                    <div class="box-body row">
                        <!-- load the view from the application if it exists, otherwise load the one in the package -->

                        @include('Security::crud.form_content', ['fields' => $crud->getFields('update', $entry->getKey())])

                    </div><!-- /.box-body -->
                    <div class="box-footer">

                        <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span
                                    class="ladda-label"><i
                                        class="fa fa-save"></i> Guardar</span></button>
                        <a href="{{ url($crud->route) }}" class="btn btn-default ladda-button"
                           data-style="zoom-in"><span
                                    class="ladda-label">Cancelar</span></a>
                    </div><!-- /.box-footer-->
                </div><!-- /.box -->
                </form>
            </div>
        </div>
    </div>
@endsection
