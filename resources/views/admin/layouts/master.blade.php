<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Mouldifi - A fully responsive, HTML5 based admin theme">
    <meta name="keywords" content="Responsive, HTML5, admin theme, business, professional, Mouldifi, web design, CSS3">
    <title>@yield('title')</title>
    <!-- Site favicon -->
    <link rel='shortcut icon' type='image/x-icon' href='{{ asset('img/center/favicon.ico') }}'/>
    <!-- /site favicon -->

    <!-- Entypo font stylesheet -->
    <link href="{{ asset('css/center/entypo.css') }}" rel="stylesheet">
    <!-- /entypo font stylesheet -->

    <!-- Font awesome stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- /font awesome stylesheet -->

    <!-- CSS3 Animate It Plugin Stylesheet -->
    <link href="{{ asset('css/center/plugins/css3-animate-it-plugin/animations.css') }}" rel="stylesheet">
    <!-- /css3 animate it plugin stylesheet -->

    <!-- Bootstrap stylesheet min version -->
    <link href="{{ asset('css/center/bootstrap.min.css') }}" rel="stylesheet">
    <!-- /bootstrap stylesheet min version -->

    <!-- Mouldifi core stylesheet -->
    <link href="{{ asset('css/center/mouldifi-core.css') }}" rel="stylesheet">
    <!-- /mouldifi core stylesheet -->

    <link href="{{ asset('css/center/mouldifi-forms.css') }}" rel="stylesheet">

    <!-- Bootstrap RTL stylesheet min version -->
    <link href="{{ asset('css/center/bootstrap-rtl.min.css') }}" rel="stylesheet">
    <!-- /bootstrap rtl stylesheet min version -->

    <!-- Mouldifi RTL core stylesheet -->
    <link href="{{ asset('css/center/mouldifi-rtl-core.css') }}" rel="stylesheet">
    <!-- /mouldifi rtl core stylesheet -->

    @yield('style-file')

    <link href="https://fonts.googleapis.com/css?family=Tajawal" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }

        .ltr {
            direction: ltr;
        }
    </style>

    <script src="{{ asset('js/center/html5shiv.min.js') }}"></script>
    <script src=" {{ asset('js/center/respond.min.js')}} "></script>

</head>
<body>

<!-- Page container -->
<div class="page-container">

    <!-- Page Sidebar -->
    <div class="page-sidebar">
        <div class="sidebar-fixed">

            <!-- Site header  -->
            <header class="site-header">
                <div class="site-logo"><a href="{{ route('admin.index', Auth::user()->username) }}"><img
                                src="{{ asset('img/center/logo.png') }}" alt="Mouldifi"
                                title="Mouldifi" style="height: 40px; width: 50px; display: block; margin: auto;"></a>
                </div>
                <div class="sidebar-collapse hidden-xs"><a class="sidebar-collapse-icon" href="#"><i
                                class="icon-menu"></i></a></div>
                <div class="sidebar-mobile-menu visible-xs"><a data-target="#side-nav" data-toggle="collapse"
                                                               class="mobile-menu-icon" href="#"><i
                                class="icon-menu"></i></a></div>
            </header>
            <!-- /site header -->

            <!-- Main navigation -->
            <ul id="side-nav" class="main-menu navbar-collapse collapse">

                <li class="has-sub"><a href="index.html"><i class="icon-book-open"></i><span
                                class="title">الدورات</span></a>
                    <ul class="nav collapse">
                        <li><a href="{{ route('admin.courses.show') }}"><span class="title">عرض الدورات</span></a></li>
                        <li><a href="{{ route('admin.courses.activation') }}"><span class="title">تفعيل الدورات</span></a>
                        </li>
                        <li><a href="{{ route('admin.courses.attendance') }}"><span class="title">سجل الحضور</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub"><a href="collapsed-sidebar.html"><i class="icon-users"></i><span
                                class="title">الطلاب</span></a>
                    <ul class="nav">
                        <li><a href="{{ route('admin.courses.payment.show') }}"><span
                                        class="title">تأكيد الدفع</span></a></li>
                        <li><a href="{{ route('admin.courses.take.attendance') }}"><span class="title">تحضير الطلاب</span></a>
                        <li><a href="{{ route('admin.courses.student.show') }}"><span
                                        class="title">عرض الطلاب</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub"><a href="collapsed-sidebar.html"><i class="icon-book"></i><span
                                class="title">الشهادات</span></a>
                    <ul class="nav">
                        <li><a href="{{ route('admin.courses.certificate.create') }}"><span class="title">إصدار شهادة</span></a></li>
                        {{--<li><a href="{{ route('admin.courses.certificate.store') }}"><span class="title">عرض الشهادات</span></a></li>--}}
                    </ul>
                </li>

                <li class="has-sub"><a href="form-basic.html"><i class="icon-user"></i><span
                                class="title">الملف الاشخصي</span></a>
                    <ul class="nav collapse">
                        <li><a href="{{ route('admin.reset.password') }}"><span class="title">كلمة المرور</span></a>
                        </li>
                    </ul>
                    <ul class="nav collapse">
                        <li><a href="{{ route('admin.edit') }}"><span class="title">بياناتي الشخصية</span></a></li>
                    </ul>
                </li>
            </ul>
            <!-- /main navigation -->

        </div>
    </div>
    <!-- /page sidebar -->

    <!-- Main container -->
    <div class="main-container">

        <!-- Main header -->
        <div class="main-header row">
            <div class="col-sm-6 col-xs-7">

                <!-- User info -->
                <ul class="user-info pull-left">
                    <li class="profile-info dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"> <img
                                    width="44" class="img-circle avatar" alt=""
                                    src="/storage/admin-images/{{ \Illuminate\Support\Facades\Auth::user()->admin->image }}">
                            @auth()
                                {{ \Illuminate\Support\Facades\Auth::user()->username }}
                            @else
                                hello word
                            @endauth
                            <span class="caret"></span>
                        </a>

                        <!-- User action menu -->
                        <ul class="dropdown-menu">

                            <li><a href="{{ route('center.edit') }}"><i class="icon-user"></i>ملفي الشخصي</a></li>
                            <li class="divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="icon-logout"></i>تسجيل الخروج
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </li>

                        </ul>
                        <!-- /user action menu -->

                    </li>
                </ul>
                <!-- /user info -->

            </div>
        </div>
        <!-- /main header -->

        <!-- Main content -->
        <div class="main-content">
            <div class="row animatedParent animateOnce z-index-50">
                <div class="col-lg-12 animated fadeInUp">
                    <h1 class="page-title">@yield('main-title')</h1>
                </div>
            </div>
            <!-- Breadcrumb -->
            <div class="row animatedParent animateOnce z-index-50">
                <div class="col-lg-12 animated fadeInUp">
                    <ol class="breadcrumb breadcrumb-2">
                        @yield('page-links')
                    </ol>
                </div>
            </div>

        @yield('content')
        <!-- Footer -->
            <footer class="animatedParent animateOnce z-index-10">
                <div class="footer-main animated fadeInUp slow">&copy; 2019 <strong><a
                                target="_blank" href="http://meccacode.com/">The Code Team </a></strong></div>
            </footer>
            <!-- /footer -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /main container -->

</div>
<!-- /page container -->

<!--Load JQuery-->
<script src="{{ asset('js/center/jquery.min.js') }}"></script>
<!-- Load CSS3 Animate It Plugin JS -->
<script src="{{ asset('js/center/plugins/css3-animate-it-plugin/css3-animate-it.js') }}"></script>
<script src="{{ asset('js/center/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/center/plugins/metismenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/center/plugins/blockui-master/jquery-ui.js') }}"></script>
<script src="{{ asset('js/center/plugins/blockui-master/jquery.blockUI.js') }}"></script>
<!--Float Charts-->
<script src="{{ asset('js/center/plugins/flot/jquery.flot.min.js') }}"></script>
<script src="{{ asset('js/center/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('js/center/plugins/flot/jquery.flot.resize.min.js') }}"></script>
<script src="{{ asset('js/center/plugins/flot/jquery.flot.selection.min.js') }}"></script>
<script src="{{ asset('js/center/plugins/flot/jquery.flot.pie.min.js') }}"></script>
<script src="{{ asset('js/center/plugins/flot/jquery.flot.time.min.js') }}"></script>

<script src="{{ asset('js/center/functions.js') }}"></script>

<!--ChartJs-->
<script src="{{ asset('js/center/plugins/chartjs/Chart.min.js') }}"></script>

<script src="{{ asset('js/center/plugins/scrollbar/perfect-scrollbar.jquery.min.js') }}"></script>

@yield('script-file')

<script>
    $(document).ready(function () {
        var $Window = $(window), $Container = $('div.page-container');

        $(".sidebar-collapse-icon").click(function (event) {
            event.preventDefault();

            if ($Container.hasClass('sidebar-collapsed')) {
                // destroy scrollbars
                $('.sidebar-fixed').perfectScrollbar('destroy');
            } else {
                // calling trigger resize
                $Window.trigger('resize');
            }
        });

        $Window.resize(function resizeScroll() {
            var windowWidth = $Window.width();
            if (windowWidth < 951) {
                // destroy scrollbars
                $('.sidebar-fixed').perfectScrollbar('destroy');
            } else {
                $('.sidebar-fixed').perfectScrollbar();
            }
        }).trigger('resize');
    });
</script>
</body>
</html>
