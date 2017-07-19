@extends('layouts.app')


@section('content')
    @if ($crud->hasAccess('list'))
        <a href="{{ url($crud->route) }}"><i
                    class="fa fa-angle-double-left"></i> {{ trans('Security::crud..back_to_all') }} <span
                    class="text-lowercase">{{ $crud->entity_name_plural }}</span></a><br><br>
    @endif

    <!-- Default box -->
    <div class="content">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('Security::crud..preview') }} <span
                            class="text-lowercase">{{ $crud->entity_name }}</h3>
            </div>
            <div class="box-body">
                {{ dump($entry) }}
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
@endsection
