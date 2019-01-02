<?php
$idModal = 'modal-agentes';
$desdePre = (new DateTime('now'))->modify('-5day')->format('Y-m-d');
$hastaPre =(new DateTime('now'))->modify('+5day')->format('Y-m-d');
?>

<table class="table table-hover" id="presentismos-table">
    <thead>
    <th>Personal</th>
    {{--<th>DNI</th>--}}
    <th>CUIT</th>
    <th>Operaciones</th>
    </thead>
    <tbody>
    @foreach($agentes as $agente)
        <tr>
            <td>{{$agente->apellido}}, {{$agente->nombre}}</td>
{{--            <td>{{$agente->dni}}</td>--}}
            <td>{{$agente->cuit}}</td>
            @include('Agentes::registro.commons.operaciones-celda', ['desdePre' => $desdePre, 'hastaPre' => $hastaPre ])

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



//            var dataTable = $('#presentismos-table').DataTable({
//                searching: false,
//                bInfo: false,
//                paging: false,
//                scrollY: 500,
//                scrollCollapse: true,
//                columnDefs: [
//                    {
//                        targets: [0],
//                        visible: false,
//                        searchable: false
//                    },
//                ],
//            });
        });

    </script>
@append