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
                <div class="site-logo"><a href="{{ route('admin.index', Auth::user()->username) }}"><img src="{{ asset('img/center/logo.png') }}" alt="Mouldifi"
                                                                                                         title="Mouldifi" style="height: 40px; width: 50px; display: block; margin: auto;"></a></div>
                <div class="sidebar-collapse hidden-xs"><a class="sidebar-collapse-icon" href="#"><i
                                class="icon-menu"></i></a></div>
                <div class="sidebar-mobile-menu visible-xs"><a data-target="#side-nav" data-toggle="collapse"
                                                               class="mobile-menu-icon" href="#"><i
                                class="icon-menu"></i></a></div>
            </header>
            <!-- /site header -->

            <!-- Main navigation -->
            <ul id="side-nav" class="main-menu navbar-collapse collapse">

                <li class="has-sub"><a href="index.html"><i class="icon-book-open"></i><span class="title">الدورات</span></a>
                    <ul class="nav collapse">
                        <li><a href="{{ route('admin.courses.show') }}"><span class="title">عرض الدورات</span></a></li>
                        <li><a href="{{ route('admin.courses.activation') }}"><span class="title">تفعيل الدورات</span></a></li>
                        <li><a href="{{ route('admin.courses.attendance') }}"><span class="title">سجل الحضور</span></a></li>
                    </ul>
                </li>

                <li class="has-sub"><a href="collapsed-sidebar.html"><i class="icon-users"></i><span
                                class="title">الطلاب</span></a>
                    <ul class="nav">
                        <li><a href="{{ route('admin.courses.payment.show') }}"><span class="title">تأكيد الدفع</span></a></li>
                        <li><a href="{{ route('admin.courses.take.attendance') }}"><span class="title">تحضير الطلاب</span></a>
                        <li><a href="{{ route('admin.courses.student.show') }}"><span class="title">عرض الطلاب</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub"><a href="collapsed-sidebar.html"><i class="icon-book"></i><span
                                class="title">الشهادات</span></a>
                    <ul class="nav">
                        <li><a href="{{ route('center.trainer.create') }}"><span class="title">إصدار شهادة</span></a></li>
                        <li><a href="{{ route('center.trainer.show') }}"><span class="title">عرض الشهادات</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub"><a href="basic-tables.html"><i class="icon-paypal"></i><span
                                class="title">التقارير المالية</span></a>
                    <ul class="nav collapse">
                        <li><a href="ecommerce-dashboard.html"><span class="title">السجل المالي</span></a></li>
                    </ul>
                </li>

                <li class="has-sub"><a href="form-basic.html"><i class="icon-user"></i><span class="title">الملف الاشخصي</span></a>
                    <ul class="nav collapse">
                        <li><a href="{{ route('admin.reset.password') }}"><span class="title">كلمة المرور</span></a></li>
                    </ul>
                    <ul class="nav collapse">
                        <li><a href="{{ route('admin.edit') }}"><span class="title">بياناتي الشخصية</span></a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="#/"><i class="icon-flow-tree"></i><span class="title">Menu Levels</span></a>
                    <ul class="nav collapse">
                        <li><a href="#/"><span class="title">Menu Level 1.1</span></a></li>
                        <li><a href="#/"><span class="title">Menu Level 1.2</span></a></li>
                        <li class="has-sub">
                            <a href="#/"><span class="title">Menu Level 1.3</span></a>
                            <ul class="nav collapse">
                                <li><a href="#/"><span class="title">Menu Level 2.1</span></a></li>
                                <li class="has-sub">
                                    <a href="#/"><span class="title">Menu Level 2.2</span></a>
                                    <ul class="nav collapse">
                                        <li class="has-sub">
                                            <a href="#/"><span class="title">Menu Level 3.1</span></a>
                                            <ul class="nav collapse">
                                                <li><a href="#/"><span class="title">Menu Level 4.1</span></a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#/"><span class="title">Menu Level 3.2</span></a></li>
                                    </ul>
                                </li>
                                <li><a href="#/"><span class="title">Menu Level 2.3</span></a></li>
                            </ul>
                        </li>
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
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
            {{--<div class="col-sm-6 col-xs-5">--}}
            {{--<div class="pull-right">--}}
            {{--<!-- User alerts -->--}}
            {{--<ul class="user-info pull-left">--}}

            {{--<!-- Notifications -->--}}
            {{--<li class="notifications dropdown">--}}
            {{--<a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-attention"></i><span class="badge badge-info">6</span></a>--}}
            {{--<ul class="dropdown-menu pull-right">--}}
            {{--<li class="first">--}}
            {{--<div class="small"><a class="pull-right danger" href="#">Mark all Read</a> You have <strong>3</strong> new notifications.</div>--}}
            {{--</li>--}}
            {{--<li>--}}
            {{--<ul class="dropdown-list">--}}
            {{--<li class="unread notification-success"><a href="#"><i class="icon-user-add pull-right"></i><span class="block-line strong">New user registered</span><span class="block-line small">30 seconds ago</span></a></li>--}}
            {{--<li class="unread notification-secondary"><a href="#"><i class="icon-heart pull-right"></i><span class="block-line strong">Someone special liked this</span><span class="block-line small">60 seconds ago</span></a></li>--}}
            {{--<li class="unread notification-primary"><a href="#"><i class="icon-user pull-right"></i><span class="block-line strong">Privacy settings have been changed</span><span class="block-line small">2 hours ago</span></a></li>--}}
            {{--<li class="notification-danger"><a href="#"><i class="icon-cancel-circled pull-right"></i><span class="block-line strong">Someone special liked this</span><span class="block-line small">60 seconds ago</span></a></li>--}}
            {{--<li class="notification-info"><a href="#"><i class="icon-info pull-right"></i><span class="block-line strong">Someone special liked this</span><span class="block-line small">60 seconds ago</span></a></li>--}}
            {{--<li class="notification-warning"><a href="#"><i class="icon-rss pull-right"></i><span class="block-line strong">Someone special liked this</span><span class="block-line small">60 seconds ago</span></a></li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="external-last"> <a href="#" class="danger">View all notifications</a> </li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<!-- /notifications -->--}}

            {{--<!-- Messages -->--}}
            {{--<li class="notifications dropdown">--}}
            {{--<a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-mail"></i><span class="badge badge-secondary">12</span></a>--}}
            {{--<ul class="dropdown-menu pull-right">--}}
            {{--<li class="first">--}}
            {{--<div class="dropdown-content-header"><i class="fa fa-pencil-square-o pull-right"></i> Messages</div>--}}
            {{--</li>--}}
            {{--<li>--}}
            {{--<ul class="media-list">--}}
            {{--<li class="media">--}}
            {{--<div class="media-left"><img alt="" class="img-circle img-sm" src="{{ asset('img/center/domnic-brown.png') }}"></div>--}}
            {{--<div class="media-body">--}}
            {{--<a class="media-heading" href="#">--}}
            {{--<span class="text-semibold">Domnic Brown</span>--}}
            {{--<span class="media-annotation pull-right">Tue</span>--}}
            {{--</a>--}}
            {{--<span class="text-muted">Your product sounds interesting I would love to check this ne...</span>--}}
            {{--</div>--}}
            {{--</li>--}}
            {{--<li class="media">--}}
            {{--<div class="media-left"><img alt="" class="img-circle img-sm" src="{{ asset('img/center/john-smith.png') }}"></div>--}}
            {{--<div class="media-body">--}}
            {{--<a class="media-heading" href="#">--}}
            {{--<span class="text-semibold">John Smith</span>--}}
            {{--<span class="media-annotation pull-right">12:30</span>--}}
            {{--</a>--}}
            {{--<span class="text-muted">Thank you for posting such a wonderful content. The writing was outstanding...</span>--}}
            {{--</div>--}}
            {{--</li>--}}
            {{--<li class="media">--}}
            {{--<div class="media-left"><img alt="" class="img-circle img-sm" src="{{ asset('img/center/stella-johnson.png') }}"></div>--}}
            {{--<div class="media-body">--}}
            {{--<a class="media-heading" href="#">--}}
            {{--<span class="text-semibold">Stella Johnson</span>--}}
            {{--<span class="media-annotation pull-right">2 days ago</span>--}}
            {{--</a>--}}
            {{--<span class="text-muted">Thank you for trusting us to be your source for top quality sporting goods...</span>--}}
            {{--</div>--}}
            {{--</li>--}}
            {{--<li class="media">--}}
            {{--<div class="media-left"><img alt="" class="img-circle img-sm" src="{{ asset('img/center/alex-dolgove.png') }}"></div>--}}
            {{--<div class="media-body">--}}
            {{--<a class="media-heading" href="#">--}}
            {{--<span class="text-semibold">Alex Dolgove</span>--}}
            {{--<span class="media-annotation pull-right">10:45</span>--}}
            {{--</a>--}}
            {{--<span class="text-muted">After our Friday meeting I was thinking about our business relationship and how fortunate...</span>--}}
            {{--</div>--}}
            {{--</li>--}}
            {{--<li class="media">--}}
            {{--<div class="media-left"><img alt="" class="img-circle img-sm" src="{{ asset('img/center/domnic-brown.png') }}"></div>--}}
            {{--<div class="media-body">--}}
            {{--<a class="media-heading" href="#">--}}
            {{--<span class="text-semibold">Domnic Brown</span>--}}
            {{--<span class="media-annotation pull-right">4:00</span>--}}
            {{--</a>--}}
            {{--<span class="text-muted">I would like to take this opportunity to thank you for your cooperation in recently completing...</span>--}}
            {{--</div>--}}
            {{--</li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<li class="external-last"> <a class="danger" href="#">All Messages</a> </li>--}}
            {{--</ul>--}}
            {{--</li>--}}
            {{--<!-- /messages -->--}}

            {{--</ul>--}}
            {{--<!-- /user alerts -->--}}

            {{--</div>--}}
            {{--</div>--}}
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
            <div class="row">
                <div class="col-lg-3 col-md-6 col-lg-offset-3 animatedParent animateOnce z-index-50">
                    <div class="panel minimal panel-default animated fadeInUp">
                        <div class="panel-heading clearfix">
                            <div class="panel-title">مسؤول الدورات</div>
                            <ul class="panel-tool-options">
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"><i
                                                class="icon-cog"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="#"><i class="icon-doc-text"></i>عرض البيانات</a></li>
                                        <li><a href="#"><i class="icon-arrows-ccw"></i>تحديث البيانات</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- panel body -->
                        <div class="panel-body">
                            <div class="stack-order">
                                <h1 class="no-margins">{{ $course_admin }}</h1>
                                <small>صلاحياتك كمسؤول</small>
                            </div>
                            <div class="bar-chart-icon"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 animatedParent animateOnce z-index-49">
                    <div class="panel minimal panel-default animated fadeInUp">
                        <div class="panel-heading clearfix">
                            <div class="panel-title">محضر الدورات</div>
                            <ul class="panel-tool-options">
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"><i
                                                class="icon-cog"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ route('center.trainer.show') }}"><i class="icon-doc-text"></i>عرض البيانات</a></li>
                                        <li><a href="#"><i class="icon-arrows-ccw"></i> تحديث البيانات</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- panel body -->
                        <div class="panel-body">
                            <div class="stack-order">
                                <h1 class="no-margins">{{ $course_attender }}</h1>
                                <small>صلاحياتك كمحضر</small>
                            </div>
                            <div class="bar-chart-icon"></div>
                        </div>
                    </div>
                </div>
            </div>
        @yield('content')
        <!-- Footer -->
            <footer class="animatedParent animateOnce z-index-10">
                <div class="footer-main animated fadeInUp slow">&copy; 2016 <strong>Mouldifi</strong> Admin Theme by <a
                            target="_blank" href="#/">G-axon</a></div>
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
