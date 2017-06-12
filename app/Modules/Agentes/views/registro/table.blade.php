<?php
$idModal = 'modal-agentes';
?>

<table class="display" id="presentismos-table">
    <thead>
    <th>Id Agente</th>
    <th>Agente</th>
    <th>CUIT</th>
    <th>Operaciones</th>
    </thead>
    <tbody>
    @foreach($agentes as $agente)
        <tr>
            <td>{{$agente->id}}</td>
            <td>{{$agente->apellido}}, {{$agente->nombre}}</td>
            <td>
                <a href="{{route('agentesEditPersonales', ['id' => $agente->id])}}"
                   class="btn btn-primary"><i class="fa fa-edit"></i></a>
                <a href="{{route('agentesDelete', ['id' => $agente->id])}}" class="btn btn-danger"><i
                            class="fa fa-trash-o"></i></a>
                <a href="{{route('agentesShow', ['id' => $agente->id])}}" class="btn btn-success"><i
                            class="fa fa-eye"></i></a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@include('parts.modal', ['idModal' => $idModal, 'titleModal' => 'Datos del agente'])
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });


            /**
             *
             * Select picker
             *
             */

            function message(obj, message, presentismo, type) {

                var wait = 2000;
                $(obj).children('.overlay').remove();

                var messenger = $(ref).parents('.input-group.margin')[0];
                $(messenger).notify(message,
                    {
                        autoHide: true,
                        // if autoHide, hide after milliseconds
                        autoHideDelay: wait,
                        position: 'top',
                        showAnimation: 'slideDown',
                        className: type,
                    });
            }



            var dataTable = $('#presentismos-table').DataTable({
                searching: false,
                bInfo: false,
                paging: false,
                scrollY: 500,
                scrollCollapse: true,
                columnDefs: [
                    {
                        targets: [0],
                        visible: false,
                        searchable: false
                    },
                ],
            });
        });

    </script>
@append