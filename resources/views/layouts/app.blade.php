<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CAT - Presentismo</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

{!! Html::style('plugins/pace/css/pace.css') !!}
{!! Html::style('plugins/bootstrap/css/bootstrap.min.css') !!}
{!! Html::style('plugins/font-awesome/css/font-awesome.min.css') !!}
{!! Html::style('plugins/select2/css/select2.min.css') !!}
{!! Html::style('plugins/adminLTE/css/AdminLTE.min.css') !!}
{!! Html::style('plugins/adminLTE/css/skins/_all-skins.min.css') !!}
{!! Html::style('plugins/datatables/css/jquery.dataTables.min.css') !!}
{!! Html::style('plugins/datatables/css/fixedHeader.bootstrap.min.css') !!}
{!! Html::style('plugins/datatables/css/responsive.dataTables.min.css') !!}
{!! Html::style('plugins/bootstrap-select/css/bootstrap-select.min.css') !!}
{!! Html::style('plugins/jquerytimepicker/css/jquery.timepicker.css') !!}
{!! Html::style('plugins/daterangepicker/css/daterangepicker.css') !!}
{!! Html::style('plugins/awesome-bootstrap-checkbox/css/awesome-bootstrap-checkbox.css') !!}
{!! Html::style('plugins/colorpicker/css/bootstrap-colorpicker.min.css') !!}
{!! Html::style('plugins/datatables-buttons-1.3.1/css/buttons.dataTables.css') !!}
{!! Html::style('css/style.css') !!}
<!-- Ionicons -->
    @yield('css')
</head>

<body class="layout-top-nav skin-yellow-light">
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

                    <div class="navbar-custom-menu pull-right">
                        <ul class="nav navbar-nav">
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle clearfix" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="{{URL::asset('images/CABA1.png')}}"
                                         class="user-image" alt="User Image"/>
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

{!! Html::script('plugins/jquery/js/jquery.min.js') !!}
{!! Html::script('plugins/datatables/js/jquery.dataTables.min.js') !!}
{!! Html::script('plugins/datatables/js/dataTables.fixedHeader.min.js') !!}
{!! Html::script('plugins/datatables/js/dataTables.responsive.min.js') !!}
{!! Html::script('plugins/bootstrap-select/js/bootstrap-select.min.js') !!}
{!! Html::script('plugins/bootstrap/js/bootstrap.min.js') !!}
{!! Html::script('plugins/select2/js/select2.min.js') !!}
{!! Html::script('plugins/iCheck/js/icheck.min.js') !!}
<!-- AdminLTE App -->
{!! Html::script('plugins/adminLTE/js/app.min.js') !!}
{{-- Notify --}}
{!! Html::script('plugins/bootstrap-notify/js/notify.min.js') !!}

{{-- Input file --}}
{!! Html::script('plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') !!}

{{-- Helper Cat --}}
{!! Html::script('js/helpers.js') !!}
{!! Html::script('js/defaults.js') !!}

{!! Html::script('plugins/pace/js/pace.min.js') !!}
{!! Html::script('plugins/moment/js/moment.js') !!}

{!! Html::script('plugins/daterangepicker/js/daterangepicker.js') !!}

{!! Html::script('plugins/jquerytimepicker/js/jquery.timepicker.min.js') !!}



@yield('scripts')
</body>
</html>