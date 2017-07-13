
@foreach($agentes as $age)
    <tr>
        <td>{{$age->apellido}}, {{$age->nombre}}</td>
        <td>{{$age->cuit}}</td>
        <td>{{$age->contrato->tipoContrato->descripcion}}</td>
        <?php $presentismos = $age->presentismos->keyBy('fecha'); ?>
        @for($i = 0; $i < count($fechasToShow) ;$i++)

                <td><?php
                    $p = (isset($presentismos[$fechasToShow[$i]['data']]) ? $presentismos[$fechasToShow[$i]['data']] : null);
                    echo \Cat\Helpers\HtmlCustoms::getSelectForTipoPresentismo($p,
                        $age->contrato->tipoContrato)
                    ?></td>
        @endfor

    </tr>
@endforeach