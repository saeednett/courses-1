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

    <link href="{{ asset('css/main/main.css') }}" rel="stylesheet">

    @yield('style-file')

    <link href="https://fonts.googleapis.com/css?family=Tajawal" rel="stylesheet">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
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

<div class="page-cover">
    <div class="message-holder">
        <p id="message"></p>
        <div class="message-details border-top">

            <div class="col-lg-4 message-details-div h-100 pt-15 text-center">
                <span class="fa fa-user"></span>
                <span class="size-13" id="message-name"></span>
            </div>

            <div class="col-lg-4 message-details-div h-100 pt-15 text-center border-right">
                <span class="fa fa-phone rtl"></span>
                <span class="size-13" id="message-phone"></span>
            </div>

            <div class="col-lg-4 message-details-div h-100 pt-15 text-center border-right">
                <span class="fa fa-envelope"></span>
                <span class="size-13" id="message-email"></span>
            </div>

        </div>
    </div>
    <div id="image-div"></div>
</div>

<!-- Page container -->
<div class="page-container">

    <!-- Page Sidebar -->
    <div class="page-sidebar">
        <div class="sidebar-fixed">

            <!-- Site header  -->
            <header class="site-header">
                <div class="site-logo"><a href="{{ route('administrator.index', Auth::user()->username) }}"><img
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
                        <li><a href="{{ route('administrator.courses.public.show') }}"><span class="title">تفعيل الدورات العامة</span></a>
                        </li>
                        <li><a href="{{ route('administrator.courses.private.show') }}"><span
                                        class="title">تفعيل الدورات الخاصة</span></a></li>
                    </ul>
                </li>

                <li class="has-sub"><a href="#"><i class="fa fa-home"></i><span
                                class="title">الجهات</span></a>
                    <ul class="nav">
                        <li><a href="{{ route('administrator.centers.show') }}"><span class="title">عرض الجهات</span></a></li>
                        <li><a href="{{ route('administrator.centers.activation.deactivation') }}"><span class="title">تفعيل الجهات</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub"><a href="#"><i class="fa fa-users"></i><span
                                class="title">الطلاب</span></a>
                    <ul class="nav">
                        <li><a href="{{ route('administrator.students.show') }}"><span
                                        class="title">عرض الطلاب</span></a></li>
                        <li><a href="{{ route('administrator.students.activation.deactivation') }}"><span class="title">تفعيل الطلاب</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub"><a href="#"><i class="fa fa-users"></i><span
                                class="title">المدربين</span></a>
                    <ul class="nav">
                        <li><a href="{{ route('administrator.trainers.show') }}"><span class="title">عرض المدربين</span></a></li>
                    </ul>
                </li>

                <li class="has-sub"><a href="#"><i class="fa fa-newspaper-o"></i><span
                                class="title">الإعلانات</span></a>
                    <ul class="nav">
                        <li><a href="{{ route('administrator.advertising.banner.create') }}"><span class="title">إضافة إعلان</span></a>
                        </li>
                        <li><a href="{{ route('administrator.advertising.banners.show') }}"><span class="title">عرض الإعلانات</span></a>
                        </li>
                    </ul>
                </li>


                <li class="has-sub"><a href="#"><i class="icon-book"></i><span
                                class="title">الشهادات</span></a>
                    <ul class="nav">
                        <li><a href="{{ route('administrator.centers.certificates.show') }}"><span
                                        class="title">عرض الشهادات</span></a></li>
                    </ul>
                </li>

                <li class="has-sub"><a href="collapsed-sidebar.html"><i class="icon-users"></i><span
                                class="title">المسؤولين</span></a>
                    <ul class="nav">
                        <li><a href="{{ route('administrator.admins.show') }}"><span class="title">عرض المسؤولين</span></a></li>
                        <li><a href="{{ route('administrator.admins.activation.deactivation') }}"><span class="title">تفعيل المسؤولين</span></a>
                        </li>
                    </ul>
                </li>

                <li class="has-sub"><a href="#"><i class="fa fa-book"></i><span
                                class="title">التقارير العامة</span></a>
                    <ul class="nav collapse">
{{--                        <li><a href="{{ route('admin.financial.report') }}"><span class="title">الطلاب</span></a></li>--}}
{{--                        <li><a href="{{ route('admin.financial.report') }}"><span class="title">الجهات</span></a></li>--}}
{{--                        <li><a href="{{ route('admin.financial.report') }}"><span class="title">المدربين</span></a></li>--}}
{{--                        <li><a href="{{ route('admin.financial.report') }}"><span class="title">المسؤولين</span></a></li>--}}
                    </ul>
                </li>

                <li class="has-sub"><a href="#"><i class="icon-mail"></i><span
                                class="title">رسائل التواصل</span></a>
                    <ul class="nav collapse">
                        <li><a href="{{ route('administrator.contact_us.show') }}"><span
                                        class="title">عرض الرسائل</span></a></li>
                    </ul>
                </li>

                <li class="has-sub"><a href="#"><i class="icon-user"></i><span
                                class="title">الملف الاشخصي</span></a>
                    <ul class="nav collapse">
                        <li><a href="{{ route('administrator.reset.password') }}"><span class="title">كلمة المرور</span></a>
                        </li>
                    </ul>
                    <ul class="nav collapse">
                        <li><a href="{{ route('administrator.edit') }}"><span class="title">بياناتي الشخصية</span></a></li>
                    </ul>
                </li>

                <li class="has-sub"><a href="#"><i class="icon-lock"></i><span class="title">إستعادة كلمة المرور</span></a>
                    <ul class="nav collapse">
                        <li><a href="{{ route('administrators.students.reset.email.show') }}"><span class="title">الطلاب</span></a></li>
                        <li><a href="{{ route('administrator.centers.reset.email.show') }}"><span class="title">الجهات</span></a></li>
                        <li><a href="{{ route('administrator.admins.reset.email.show') }}"><span class="title">المسؤولين</span></a></li>
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
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">

                            @if(\Illuminate\Support\Facades\Auth::user()->administrator->image == "default.jpg")
                                <img width="44" class="img-circle avatar" alt=""
                                     src="{{ asset('img/main/default.png') }}">
                            @else
                                <img width="44" class="img-circle avatar" alt=""
                                     src="/storage/administrator-images/{{ \Illuminate\Support\Facades\Auth::user()->administrator->image }}">
                            @endif

                            @auth()
                                {{ \Illuminate\Support\Facades\Auth::user()->username }}
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
            <div class="row">
                <div class="col-lg-3 col-md-٦ animatedParent animateOnce z-index-50">
                    <div class="panel minimal panel-default animated fadeInUp">
                        <div class="panel-heading clearfix">
                            <div class="panel-title">الجهات</div>
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
                                <h1 class="no-margins">{{ $all_centers }}</h1>
                                <small>الجهات المسجلة في النظام</small>
                            </div>
                            <div class="bar-chart-icon"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 animatedParent animateOnce z-index-49">
                    <div class="panel minimal panel-default animated fadeInUp">
                        <div class="panel-heading clearfix">
                            <div class="panel-title">الدورات</div>
                            <ul class="panel-tool-options">
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"><i
                                                class="icon-cog"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ route('center.trainer.show') }}"><i class="icon-doc-text"></i>عرض
                                                البيانات</a></li>
                                        <li><a href="#"><i class="icon-arrows-ccw"></i> تحديث البيانات</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- panel body -->
                        <div class="panel-body">
                            <div class="stack-order">
                                <h1 class="no-margins">{{ $all_courses }}</h1>
                                <small>الدورات المسجلة في النظام</small>
                            </div>
                            <div class="bar-chart-icon"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 animatedParent animateOnce z-index-49">
                    <div class="panel minimal panel-default animated fadeInUp">
                        <div class="panel-heading clearfix">
                            <div class="panel-title">الطلاب</div>
                            <ul class="panel-tool-options">
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"><i
                                                class="icon-cog"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ route('center.trainer.show') }}"><i class="icon-doc-text"></i>عرض
                                                البيانات</a></li>
                                        <li><a href="#"><i class="icon-arrows-ccw"></i> تحديث البيانات</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- panel body -->
                        <div class="panel-body">
                            <div class="stack-order">
                                <h1 class="no-margins">{{ $all_students }}</h1>
                                <small>الطلاب المسجلين في النظام</small>
                            </div>
                            <div class="bar-chart-icon"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 animatedParent animateOnce z-index-49">
                    <div class="panel minimal panel-default animated fadeInUp">
                        <div class="panel-heading clearfix">
                            <div class="panel-title">المدربين</div>
                            <ul class="panel-tool-options">
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"><i
                                                class="icon-cog"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="{{ route('center.trainer.show') }}"><i class="icon-doc-text"></i>عرض
                                                البيانات</a></li>
                                        <li><a href="#"><i class="icon-arrows-ccw"></i> تحديث البيانات</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- panel body -->
                        <div class="panel-body">
                            <div class="stack-order">
                                <h1 class="no-margins">{{ $all_trainers }}</h1>
                                <small>المدربين المسجلين في النظام</small>
                            </div>
                            <div class="bar-chart-icon"></div>
                        </div>
                    </div>
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
