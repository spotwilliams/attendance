<table class="table table-hover">

    <thead>
    <th>Personal</th>
    {{--<th>DNI</th>--}}
    <th>CUIT</th>
    <th>Base</th>
    <th>Rango fechas</th>
    <th>Ir</th>
    </thead>
    <tbody>
    @include('Presentismo::por-agente.rows')
    </tbody>
</table>