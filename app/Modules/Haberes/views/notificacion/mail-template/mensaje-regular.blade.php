<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td bgcolor="#41f49b" nowrap>
            <img border="0"
                 src="{{ Request::getSchemeAndHttpHost() }}/vendor/beautymail/assets/images/widgets/spacer.gif"
                 width="5" height="1">
        </td>
        <td width="100%" bgcolor="#ffffff">

            <table width="100%" cellpadding="20" cellspacing="0" border="0">
                <tr>
                    <td bgcolor="#ffffff" class="contentblock">
                        @if($paquete->estado()->first()->codigo === \Remain\Models\Estado::TOPE_INDIVIDUAL)
                            Este mail es para notificarle que Liquidaciones no ha aprobado todos los conceptos registrados para
                            los agentes pertenecientes a <b>{{$grupo->nombre}}</b> (y sub&aacute;reas), por lo que se
                            requiere su revisi&oacute;n
                        @else
                            Este mail es para notificarle que ya est&aacute;n disponibles los conceptos de los agentes
                            pertenecientes a <b>{{$grupo->nombre}}</b> (y sub&aacute;reas)
                            para ser impresos y firmados.
                        @endif
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
<img border="0" src="{{ Request::getSchemeAndHttpHost() }}/vendor/beautymail/assets/images/widgets/spacer.gif" width="1"
     height="15" class="divider">
<br>
