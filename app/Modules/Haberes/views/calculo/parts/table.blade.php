<div class="table-responsive">

    <table class="resultados">
        <thead>
        <tr>
            <th></th>
            <th>Agente</th>
            <th>Monto a facturar</th>
            <th>D&iacute;s registrados</th>
            <th>Justificados</th>
            <th>No justificados</th>
        </tr>
        </thead>
    </table>

</div>

<div class="text-center">
    @if(isset($agentes) and !$agentes->isEmpty())
        {{$agentes->links()}}
    @endif
</div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('table.resultados').dataTable({
                searching: false,
                bInfo: false,
                paging: false,
                ordering: false,
            });
        })
    </script>
@append
