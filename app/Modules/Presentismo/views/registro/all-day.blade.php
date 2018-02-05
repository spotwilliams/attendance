@foreach($agentes as $age)
    <tr>
        <td>
            @if($age->observacion !== null)
                <span
                        class="observacion-agente"
                        data-toggle="popover"
                      data-placement="top"
                      data-content="{{$age->observacion}}">
                <i class="fa fa-comment-o"></i>
                </span>
            @endif
            {{$age->apellido}}, {{$age->nombre}}
        </td>
        <td>{{$age->cuit}}</td>
        <td>{{$age->contrato->tipoContrato->descripcion}}</td>
        <?php $presentismos = $age->presentismos->keyBy('fecha'); ?>
        @for($i = 0; $i < count($fechasToShow) ;$i++)

            <td data-agente="{{$age->id}}"><?php
                $p = (isset($presentismos[$fechasToShow[$i]['data']]) ? $presentismos[$fechasToShow[$i]['data']] : null);
                echo \Cat\Helpers\HtmlCustoms::getSelectForTipoPresentismo($p,
                    $age->contrato->tipoContrato)
                ?></td>
        @endfor

    </tr>
@endforeach

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-toggle="popover"].observacion-agente').popover({
                trigger: 'hover'
            });
        })
    </script>
@append

