<!DOCTYPE html>
<!--
Template Name: conquer - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.2.0
Version: 2.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/conquer-responsive-admin-dashboard-template/3716838?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Sistem Inventaris Klinik UBAYA</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="MobileOptimized" content="320">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('conquer/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('conquer/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('conquer/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('conquer/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="{{ asset('conquer/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('conquer/plugins/fullcalendar/fullcalendar/fullcalendar.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('conquer/plugins/jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="{{ asset('conquer/css/style-conquer.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('conquer/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('conquer/css/style-responsive.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('conquer/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('conquer/css/pages/tasks.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('conquer/css/themes/default.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ asset('conquer/css/custom.css') }}" rel="stylesheet" type="text/css" />

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> --}}
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />

    @yield('css')

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="page-header-fixed">
    <!-- BEGIN HEADER -->
    <div class="header navbar navbar-fixed-top">
        <!-- BEGIN TOP NAVIGATION BAR -->
        <div class="header-inner">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="index.html">
                    <img src="{{ asset('conquer/img/logo.png') }}" alt="logo" />
                </a>
            </div>
            {{-- <form class="search-form search-form-header" role="form" action="index.html">
                <div class="input-icon right">
                    <i class="icon-magnifier"></i>
                    <input type="text" class="form-control input-sm" name="query" placeholder="Search...">
                </div>
            </form> --}}
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <img src="{{ asset('conquer/img/menu-toggler.png') }}" alt="" />
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <ul class="nav navbar-nav pull-right">

                <li class="devider">
                    &nbsp;
                </li>
                <!-- BEGIN USER LOGIN DROPDOWN -->
                <li class="dropdown user">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                        data-close-others="true">
                        <img alt="" src="{{ asset('conquer/img/avatar3_small.jpg') }}" />
                        <span class="username username-hide-on-mobile">
                            @auth
                                {{ Auth::user()->name }}
                            @endauth
                        </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="extra_profile.html"><i class="fa fa-user"></i> My Profile</a>
                        </li>
                        
                        
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                        <li class="divider">
                        </li>
                        <li>
                            {{-- <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-link" type="submit">{{ _('Log out') }}</button></form> --}}
                        </li>
                    </ul>
                </li>
                <!-- END USER LOGIN DROPDOWN -->
            </ul>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->
    <div class="clearfix">
    </div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <!-- DOC: for circle icon style menu apply page-sidebar-menu-circle-icons class right after sidebar-toggler-wrapper -->
                <ul class="page-sidebar-menu">
                    <li class="sidebar-toggler-wrapper">
                        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                        <div class="sidebar-toggler">
                        </div>
                        <div class="clearfix">
                        </div>
                        <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                    </li>
                    <li class="sidebar-search-wrapper">
                        <form class="search-form" role="form" action="index.html" method="get">
                            <div class="input-icon right">
                                <i class="icon-magnifier"></i>
                                <input type="text" class="form-control" name="query" placeholder="Search...">
                            </div>
                        </form>
                    </li>
                    <li class="start ">
                        <a href="index.html">
                            <i class="icon-home"></i>
                            <span class="title">Dashboard</span>
                            <span class="selected"></span>
                        </a>
                    <li>
                        <a href="javascript:;">
                            <i class="icon-puzzle"></i>
                            <span class="title">Master</span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a href="javascript:;">
                                    <span class="title">Manajemen</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-list"></i>
                                            Barang Abis Pakai
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li>
                                                <form action="{{ url('productabispakai') }}" method="get">
                                                    <a href="javascript:;" onclick="this.parentNode.submit();">
                                                        Umum
                                                        <input type="hidden" name="kategori" value="Umum">
                                                    </a>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ url('productabispakai') }}" method="get">
                                                    <a href="javascript:;" onclick="this.parentNode.submit();">
                                                        Poli Gigi
                                                        <input type="hidden" name="kategori" value="Poli Gigi">
                                                    </a>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                    @can('staf')
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-list"></i>
                                            Barang Pinjam
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <form action="{{ url('productpinjam') }}" method="get">
                                                <a href="javascript:;" onclick="this.parentNode.submit();">
                                                    Umum
                                                    <input type="hidden" name="kategori" value="Umum">
                                                </a>
                                            </form>
                                            <li>
                                                <form action="{{ url('productpinjam') }}" method="get">
                                                    <a href="javascript:;" onclick="this.parentNode.submit();">
                                                        Poli Gigi
                                                        <input type="hidden" name="kategori" value="Poli Gigi">
                                                    </a>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-list"></i>
                                            Barang Pinjam Kembali
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li>
                                                <form action="{{ url('barangkembali') }}" method="get">
                                                    <a href="javascript:;" onclick="this.parentNode.submit();">
                                                        Umum
                                                        <input type="hidden" name="kategori" value="Umum">
                                                    </a>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ url('barangkembali') }}" method="get">
                                                    <a href="javascript:;" onclick="this.parentNode.submit();">
                                                        Poli Gigi
                                                        <input type="hidden" name="kategori" value="Poli Gigi">
                                                    </a>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <i class="icon-list"></i>
                                            Batch Product Abis Pakai
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li>
                                                <form action="{{ url('batchprod') }}" method="get">
                                                    <a href="javascript:;" onclick="this.parentNode.submit();">
                                                        Umum
                                                        <input type="hidden" name="kategori" value="Umum">
                                                    </a>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ url('batchprod') }}" method="get">
                                                    <a href="javascript:;" onclick="this.parentNode.submit();">
                                                        Poli Gigi
                                                        <input type="hidden" name="kategori" value="Poli Gigi">
                                                    </a>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="{{ url('identitaspeminjam') }}">
                                            <i class="icon-list"></i>
                                            Identitas Peminjam</a>
                                    </li>
                                    @endcan
                                </ul>
                            </li>
                            @can('staf')
                            <li>
                                <a href="javascript:;">
                                    <span class="title">Laporan</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="{{ url('laporanharianbarangabispakai') }}">
                                            <i class="icon-list"></i>
                                            Laporan harian barang abis pakai</a>
                                    </li>
                                    <li>
                                        <a href="{{ url('back/albumProduct') }}">
                                            <i class="icon-book-open"></i>
                                            Laporan harian barang pinjaman</a>
                                    </li>
                                </ul>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    </li>

                </ul>
                <!-- END SIDEBAR MENU -->
            </div>
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            @yield('konten')
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <script src="{{ asset('conquer/plugins/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/jquery-migrate-1.2.1.min.js') }}" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="{{ asset('conquer/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('conquer/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="{{ asset('conquer/plugins/jqvmap/jqvmap/jquery.vmap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('conquer/plugins/jquery.peity.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/jquery.pulsate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/jquery-knob/js/jquery.knob.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/flot/jquery.flot.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/flot/jquery.flot.resize.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/bootstrap-daterangepicker/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/plugins/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('conquer/plugins/gritter/js/jquery.gritter.js') }}" type="text/javascript"></script>
    <!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
    <script src="{{ asset('conquer/plugins/fullcalendar/fullcalendar/fullcalendar.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('conquer/plugins/jquery-easypiechart/jquery.easypiechart.min.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('conquer/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('conquer/scripts/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/scripts/index.js') }}" type="text/javascript"></script>
    <script src="{{ asset('conquer/scripts/tasks.js') }}" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script>
        jQuery(document).ready(function() {
            App.init(); // initlayout and core plugins
            Index.init();
            Index.initJQVMAP(); // init index page's custom scripts
            Index.initCalendar(); // init index page's custom scripts
            Index.initCharts(); // init index page's custom scripts
            Index.initChat();
            Index.initMiniCharts();
            Index.initPeityElements();
            Index.initKnowElements();
            Index.initDashboardDaterange();
            Tasks.initDashboardWidget();
        });
    </script>
    <script src="https://code.jquery.com/jquery-2.2.0.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    {{-- <script src="{{ asset('js/jquery.editable.min.js') }}" type="text/javascript"></script> --}}
    @yield('javascript')
    <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->

</html>
