<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CAT - Presentismo</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

<link rel="stylesheet" href="{{ asset('plugins/pace/css/pace.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/adminLTE/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/adminLTE/css/skins/_all-skins.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables/css/fixedHeader.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/jquerytimepicker/css/jquery.timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/css/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/awesome-bootstrap-checkbox/css/awesome-bootstrap-checkbox.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/colorpicker/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons-1.3.1/css/buttons.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/inputmask/css/inputmask.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fullcalendar/css/fullcalendar.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/sliptree-bootstrap-tokenfield/css/bootstrap-tokenfield.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/sliptree-bootstrap-tokenfield/css/tokenfield-typeahead.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<!-- Ionicons -->
    @yield('css')
</head>

<body class="layout-top-nav skin-yellow-light fixed">
@if (!Auth::guest())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
                <div class="container">

                    <div class="navbar-header">
                        <a href="/" class="navbar-brand"><b>CAT</b></a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    {{--MAIN MENU --}}
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            @include('layouts.menu')
                        </ul>
                    </div>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="{{URL::asset('images/CABA1.png')}}" class="user-image" alt="User Image"/>
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="{{URL::asset('images/CABA1.png')}}"
                                             class="img-circle" alt="User Image"/>
                                        <p>
                                            {!! Auth::user()->name !!}
                                            ({!! Auth::user()->email !!})
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        {{--<div class="pull-left">--}}
                                        {{--<a href="#" class="btn btn-default btn-flat">Profile</a>--}}
                                        {{--</div>--}}
                                        <div class="pull-right">
                                            <a href="{!! url('/logout') !!}"
                                               class="btn btn-default btn-flat">Salir</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>

                        </ul>
                    </div>

                </div>

            </nav>
        </header>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            {{--<section class="content-header" style="min-height: 50px!important;">--}}
            {{--<ul class="breadcrumb">--}}
            {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
            {{--<li class="active">Dashboard</li>--}}
            {{--</ul>--}}
            {{--</section>--}}
            @yield('content')
        </div>

        <!-- Main Footer -->
    {{--<footer class="main-footer" style="max-height: 100px;text-align: center">--}}
    {{--<strong>Copyright © 2017 <a>CAT</a>.</strong>--}}
    {{--</footer>--}}
    <!-- The Right Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li class="active">
                    <a href="#colores-referencia"
                       data-toggle="tab"
                       aria-expanded="true">
                        <i class="fa fa-slack"></i>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="colores-referencia">
                    <div>
                        @include('common.tipo-presentismos.as-list')
                    </div>
                </div>
            </div>
            <!-- Content of the sidebar goes here -->
        </aside>
        <!-- The sidebar's background -->
        <!-- This div must placed right after the sidebar for it to work-->
        <div class="control-sidebar-bg"></div>

    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{!! url('/') !!}">

                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/home') !!}">P&aacute;gina principal</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/login') !!}">Ingresar</a></li>
                    {{--<li><a href="{!! url('/register') !!}">Register</a></li>--}}
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
@endif

<script src="{{ asset('plugins/jquery/js/jquery.min.js') }}"></script>

<script src="{{ asset('plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/dataTables.fixedHeader.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-empty-columns/js/dataTables.hideEmptyColumns.min.js') }}"></script>

<script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-select/js/i18n/defaults-es_ES.js') }}"></script>
<script src="{{ asset('plugins/slimScroll/js/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('plugins/iCheck/js/icheck.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('plugins/adminLTE/js/app.min.js') }}"></script>
{{-- Notify --}}
<script src="{{ asset('plugins/bootstrap-notify/js/notify.min.js') }}"></script>

{{-- Input file --}}
<script src="{{ asset('plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>

<script src="{{ asset('plugins/pace/js/pace.min.js') }}"></script>
<script src="{{ asset('plugins/moment/js/moment.js') }}"></script>
<script src="{{ asset('plugins/chart/js/Chart.js') }}"></script>

<script src="{{ asset('plugins/daterangepicker/js/daterangepicker.js') }}"></script>

<script src="{{ asset('plugins/jquerytimepicker/js/jquery.timepicker.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons-1.3.1/js/dataTables.buttons.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons-1.3.1/js/buttons.colVis.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons-1.3.1/js/buttons.html5.js') }}"></script>
<script src="{{ asset('plugins/colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('plugins/inputmask/js/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/fullcalendar/js/fullcalendar.min.js') }}"></script>

<script src="{{ asset('plugins/sliptree-bootstrap-tokenfield/js/bootstrap-tokenfield.min.js') }}"></script>

{{--<script src="{{ asset('plugins/datatables-double-scroll/js/datatables-double-scroll.js') }}"></script>--}}

{{-- Helper Cat --}}
<script src="{{ asset('js/helpers.js') }}"></script>
<script src="{{ asset('js/defaults.js') }}"></script>


<script type="text/javascript">
    $.fn.selectpicker.Constructor.DEFAULTS.actionsBox = true;
</script>
@yield('scripts')
</body>
</html>
