@extends('layouts.app')

@section('content')

    <div class="content">
    @include('flash::message')
    <!-- Default box -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Listado de {{$crud->entity_name_plural}}</h3>
                      @include('Security::crud.inc.button_stack', ['stack' => 'top'])

            </div>
            <div class="box-body">

                <table id="crudTable" class="table table-bordered table-striped display">
                    <thead>
                    <tr>
                        @if ($crud->details_row)
                            <th></th> <!-- expand/minimize button column -->
                        @endif

                        {{-- Table columns --}}
                        @foreach ($crud->columns as $column)
                            <th>{{ $column['label'] }}</th>
                        @endforeach

                        @if ( $crud->buttons->where('stack', 'line') )
                            <th>Acciones</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>

                    @if (!$crud->ajaxTable())
                        @foreach ($entries as $k => $entry)
                            <tr data-entry-id="{{ $entry->getKey() }}">

                                @if ($crud->details_row)
                                    @include('Security::crud.columns.details_row_button')
                                @endif

                                {{-- load the view from the application if it exists, otherwise load the one in the package --}}
                                @foreach ($crud->columns as $column)
                                    @if (!isset($column['type']))
                                        @include('Security::crud.columns.text')
                                    @else
                                        @if(view()->exists('vendor.backpack.crud.columns.'.$column['type']))
                                            @include('vendor.backpack.crud.columns.'.$column['type'])
                                        @else
                                            @if(view()->exists('Security::crud.columns.'.$column['type']))
                                                @include('Security::crud.columns.'.$column['type'])
                                            @else
                                                @include('Security::crud.columns.text')
                                            @endif
                                        @endif
                                    @endif

                                @endforeach

                                @if ($crud->buttons->where('stack', 'line')->count())
                                    <td>
                                        @include('Security::crud.inc.button_stack', ['stack' => 'line'])
                                    </td>
                                @endif

                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                    {{--<tfoot>--}}
                    {{--<tr>--}}
                    {{--@if ($crud->details_row)--}}
                    {{--<th></th> <!-- expand/minimize button column -->--}}
                    {{--@endif--}}

                    {{-- Table columns --}}
                    {{--@foreach ($crud->columns as $column)--}}
                    {{--<th>{{ $column['label'] }}</th>--}}
                    {{--@endforeach--}}

                    {{--@if ( $crud->buttons->where('stack', 'line') )--}}
                    {{--<th>Acciones</th>--}}
                    {{--@endif--}}
                    {{--</tr>--}}
                    {{--</tfoot>--}}
                </table>

            </div><!-- /.box-body -->

            {{--    @include('Security::crud.inc.button_stack', ['stack' => 'bottom'])--}}

        </div><!-- /.box -->
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            var table = $("#crudTable").DataTable({
                @if ($crud->ajaxTable())
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url($crud->route.'/search') }}",
                    "type": "POST"
                },
                @endif
            });

            $.ajaxPrefilter(function (options, originalOptions, xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-XSRF-TOKEN', token);
                }
            });

            // make the delete button work in the first result page
            register_delete_button_action();

            // make the delete button work on subsequent result pages
            $('#crudTable').on('draw.dt', function () {
                register_delete_button_action();

                @if ($crud->details_row)
register_details_row_button_action();
                @endif
            }).dataTable();

            function register_delete_button_action() {
                $("[data-button-type=delete]").unbind('click');
                // CRUD Delete
                // ask for confirmation before deleting an item
                $("[data-button-type=delete]").click(function (e) {
                    e.preventDefault();
                    var delete_button = $(this);
                    var delete_url = $(this).attr('href');

                    if (confirm("{{ trans('Security::crud..delete_confirm') }}") == true) {
                        $.ajax({
                            url: delete_url,
                            type: 'DELETE',
                            success: function (result) {
                                // Show an alert with the result
                                new PNotify({
                                    title: "{{ trans('Security::crud..delete_confirmation_title') }}",
                                    text: "{{ trans('Security::crud..delete_confirmation_message') }}",
                                    type: "success"
                                });
                                // delete the row from the table
                                delete_button.parentsUntil('tr').parent().remove();
                            },
                            error: function (result) {
                                // Show an alert with the result
                                new PNotify({
                                    title: "{{ trans('Security::crud..delete_confirmation_not_title') }}",
                                    text: "{{ trans('Security::crud..delete_confirmation_not_message') }}",
                                    type: "warning"
                                });
                            }
                        });
                    } else {
                        new PNotify({
                            title: "{{ trans('Security::crud..delete_confirmation_not_deleted_title') }}",
                            text: "{{ trans('Security::crud..delete_confirmation_not_deleted_message') }}",
                            type: "info"
                        });
                    }
                });
            }


            @if ($crud->details_row)
            function register_details_row_button_action() {
                // Add event listener for opening and closing details
                $('#crudTable tbody').on('click', 'td .details-row-button', function () {
                    var tr = $(this).closest('tr');
                    var btn = $(this);
                    var row = table.row(tr);

                    if (row.child.isShown()) {
                        // This row is already open - close it
                        $(this).children('i').removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
                        $('div.table_row_slider', row.child()).slideUp(function () {
                            row.child.hide();
                            tr.removeClass('shown');
                        });
                    }
                    else {
                        // Open this row
                        $(this).children('i').removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
                        // Get the details with ajax
                        $.ajax({
                            url: '{{ Request::url() }}/' + btn.data('entry-id') + '/details',
                            type: 'GET',
                            // dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
                            // data: {param1: 'value1'},
                        })
                            .done(function (data) {
                                // console.log("-- success getting table extra details row with AJAX");
                                row.child("<div class='table_row_slider'>" + data + "</div>", 'no-padding').show();
                                tr.addClass('shown');
                                $('div.table_row_slider', row.child()).slideDown();
                                register_delete_button_action();
                            })
                            .fail(function (data) {
                                // console.log("-- error getting table extra details row with AJAX");
                                row.child("<div class='table_row_slider'>{{ trans('Security::crud..details_row_loading_error') }}</div>").show();
                                tr.addClass('shown');
                                $('div.table_row_slider', row.child()).slideDown();
                            })
                            .always(function (data) {
                                // console.log("-- complete getting table extra details row with AJAX");
                            });
                    }
                });
            }

            register_details_row_button_action();
            @endif


        });
    </script>
@endsection
