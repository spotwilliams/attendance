<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $senderName or '' }}</title>
    @include('Haberes::notificacion.mail-template.css')
</head>
<body bgcolor="#e4e4e4"
      style="-webkit-font-smoothing: antialiased;width:100% !important;background:#e4e4e4;-webkit-text-size-adjust:none;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#e4e4e4">
    <tr>
        <td bgcolor="#e4e4e4" width="100%">

            <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="table">
                <tr>
                    <td width="600" class="cell">

                        <table width="600" cellpadding="0" cellspacing="0" border="0" class="table">
                            <tr>
                                <td width="250" bgcolor="#e4e4e4" class="logocell">
                                    <img border="0"
                                         src="{{ Request::getSchemeAndHttpHost() }}/vendor/beautymail/assets/images/widgets/spacer.gif"
                                         width="1" height="20" class="hide">
                                    <br class="hide">
                                    @if (isset($logo))
                                        <img src="{{ $logo['path'] }}" width="{{ $logo['width'] }}"
                                             height="{{ $logo['height'] }}" alt="{{ $senderName or '' }}"
                                             style="-ms-interpolation-mode:bicubic;">
                                    @endif
                                    <br>
                                    <img border="0"
                                         src="{{ Request::getSchemeAndHttpHost() }}/vendor/beautymail/assets/images/widgets/spacer.gif"
                                         width="1" height="10" class="hide"><br class="hide"></td>
                                <td align="right" width="350" class="hide"
                                    style="color:#a6a6a6;font-size:12px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;text-shadow: 0 1px 0 #ffffff;"
                                    valign="top" bgcolor="#e4e4e4"><img border="0"
                                                                        src="{{ Request::getSchemeAndHttpHost() }}/vendor/beautymail/assets/images/widgets/spacer.gif"
                                                                        width="1" height="63"><br></td>
                            </tr>
                        </table>

                        @include($mensaje)

                    </td>
                </tr>
            </table>


            <table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f2f2f2">
                <tr>
                    <td>

                        @include('Haberes::notificacion.mail-template.spacer')
                        @include('Haberes::notificacion.mail-template.spacer')

                        <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="table">
                            <tr>
                                <td width="600" nowrap bgcolor="#f2f2f2" class="cell">

                                    <table width="600" cellpadding="0" cellspacing="0" border="0" class="table">
                                        <tr>
                                            <td width="380" valign="top" class="footershow">
                                                @include('Haberes::notificacion.mail-template.spacer')

                                                <p style="color:#a6a6a6;font-size:12px;font-family:Helvetica,Arial,sans-serif;margin-top:0;margin-bottom:15px;padding-top:0;padding-bottom:0;line-height:18px;"
                                                   class="reminder">Direcci&oacute;n General de Cuerpo de Agentes de Control de Tr&aacute;nsito y Transporte</p>
                                            </td>
                                            <td align="right" width="220"
                                                style="color:#a6a6a6;font-size:12px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;text-shadow: 0 1px 0 #ffffff;"
                                                valign="top" class="hide">
                                                @include('Haberes::notificacion.mail-template.logo')

                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>

                        @include('Haberes::notificacion.mail-template.spacer')


                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>

</body>
</html>
