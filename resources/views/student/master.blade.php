<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('mete')
    <meta name="author" content="course.com">

    <link rel="shortcut icon" href="https://lammt.com/resource/img/favicon.ico">


    {{--<link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    {{--<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">


    {{--<link href="{{ asset('css/bootstrap-theme.css') }}" rel="stylesheet" type="text/css">--}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
    {{--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">--}}


    {{--<link href="{{ asset('css/bootstrap-rtl.min.css') }}" rel="stylesheet" type="text/css">--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.3.4/css/bootstrap-rtl.css" rel="stylesheet"
          type="text/css">

    {{--<link href="{{ asset('css/chosen.min.css') }}" rel="stylesheet" type="text/css">--}}
    {{--<link href="{{ asset('css/chosen-bootstrap.css') }}" rel="stylesheet" type="text/css">--}}

    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">

    @yield('style-file-1')
    @yield('style-file-2')
    @yield('style-file-3')

    {{--<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>--}}
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    @yield('script-file-1')
    @yield('script-file-2')
    @yield('script-file-3')
    {{--<script src="{{ asset('js/main.js') }}"></script>--}}
    {{--<script src="{{ asset('js/chosen.jquery.min.js') }}"></script>--}}
    {{--<script src="{{ asset('js/footer.js') }}"></script>--}}
    {{--<script async="" src="{{ asset('js/hotjar-182516.js') }}"></script>--}}
    {{--<script async="" src="{{ asset('js/modules-27da28df520762f53faa377587187f3a.js') }}"></script>--}}
</head>
<body class="rtl">
<div class="wrap">
    <header class="site-header">
        <div class="center-wrap logo-search">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12 logo-wrap">
                    <a href="https://lammt.com/" title="Lammt">
                        <img height="75" width="160" src="{{ asset('img/logo2.png') }}" alt="logo" title="Lammt">
                    </a>
                    <form action="https://lammt.com/" method="GET" class="city-filter city-filter-header">
                        <select name="city" class="form-control">
                            <option value="all">كل المدن</option>
                            <option value="Jeddah">جدة</option>
                            <option value="Riyadh">الرياض</option>
                            <option value="Dammam">الدمام</option>
                            <option value="Mecca">مكة المكرمة</option>
                            <option value="Medina">المدينة المنورة</option>
                            <option value="Khobar">الخبر</option>
                            <option value="Al-Ahsa">الأحساء</option>
                            <option value="Ta&#39;if">الطائف</option>
                            <option value="Khamis Mushait">خميس مشيط</option>
                            <option value="Buraidah">بريدة</option>
                            <option value="Jubail">الجبيل</option>
                            <option value="AlJouf">الجوف</option>
                            <option value="Yunba">ينبع</option>
                            <option value="Njran">نجران</option>
                            <option value="Tabuk">تبوك</option>
                            <option value="Hail">حائل</option>
                            <option value="Assir">عسير</option>
                            <option value="Abha">أبها</option>
                            <option value="Qassim">القصيم</option>
                            <option value="HaferAlbaten">حفرالباطن</option>
                            <option value="Unaizah">عنيزة</option>
                            <option value="ِAlkharg">الخرج</option>
                            <option value="AlOla">العلا</option>
                            <option value="Bahrain">البحرين</option>
                            <option value="Jazan">جازان</option>
                            <option value="Dhahran">الظهران</option>
                            <option value="Kuwait">الكويت</option>
                            <option value="Arar">عرعر</option>
                            <option value="Qatif">القطيف</option>
                        </select>
                    </form>
                    <div class="menu-wrap top-menu-wrap">
                        <div class="center-wrap">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                                            data-target="#top-menu">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="row menu">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="collapse navbar-collapse" id="top-menu">
                                        <ul class="nav navbar-nav navbar-right head-nav">
                                            <li class="first"><a href="https://lammt.com/" title="الرئيسية">الرئيسية</a>
                                            </li>
                                            <li><a href="https://lammt.com/page/about" title="عن لمة">عن لمة</a></li>
                                            <li><a href="https://lammt.com/this-month" title="فعاليات الشهر">فعاليات
                                                    الشهر</a></li>
                                            <li class="last"><a href="https://lammt.com/page/contact"
                                                                title="تواصل معنا">تواصل معنا</a></li>
                                            <li>
                                                <form action="https://lammt.com/search/results"
                                                      class="search-inner search-inner-ar search-inner-in-menu"
                                                      method="GET">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                    <input type="text" name="search_query" placeholder="بحث">
                                                </form>
                                            </li>
                                        </ul>
                                        <ul class="nav navbar-nav navbar-left head-nav">
                                            <li class="dropdown ">
                                                <button type="button" class="down-caret dropdown-toggle"
                                                        data-toggle="dropdown">
                                                    <span class="glyphicon glyphicon-user"></span> دخول <b
                                                            class="caret"></b>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li><a href="https://lammt.com/account/sign-in" title="تسجيل دخول">تسجيل
                                                            دخول</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="https://lammt.com/account/sign-up" title="تسجيل جديد">تسجيل
                                                            جديد</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 text-left">
                    <a class="pricing_header_link" href="https://lammt.com/pricing">أضف فعاليتك الآن!</a>
                </div>
            </div>
        </div>
        <div class="menu-wrap bottom-menu-wrap">
            <div class="center-wrap">

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="collapse navbar-collapse top-menu">
                            <ul class="nav navbar-nav navbar-right head-nav">
                                <li class="first"><a href="https://lammt.com/" title="الرئيسية">الرئيسية</a></li>
                                <li><a href="https://lammt.com/page/about" title="عن لمة">عن لمة</a></li>
                                <li><a href="https://lammt.com/this-month" title="فعاليات الشهر">فعاليات الشهر</a></li>
                                <li class="last"><a href="https://lammt.com/page/contact" title="تواصل معنا">تواصل
                                        معنا</a></li>
                            </ul>
                            <ul class="nav navbar-nav navbar-left head-nav header-menu">
                                <li class="dropdown ">
                                    @if(\Illuminate\Support\Facades\Auth::check())
                                        <button type="button" class="down-caret dropdown-toggle">
                                            <span class="glyphicon glyphicon-user"></span> {{ \Illuminate\Support\Facades\Auth::user()->username }} <b class="caret"></b>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="https://lammt.com/account/sign-in" title="ملفي الشخصي">ملفي الشخصي</a></li>
                                            <li><a href="https://lammt.com/account/sign-in" title="تذاكري">تذاكري</a></li>
                                            <li><a href="https://lammt.com/account/sign-in" title="شهاداتي">شهاداتي</a></li>
                                            <li class="divider"></li>
                                            <li><a href="https://lammt.com/account/sign-up" title="تسجيل الخروج">تسجيل الخروج</a></li>
                                        </ul>
                                    @else
                                        <button type="button" class="down-caret dropdown-toggle">
                                            <span class="glyphicon glyphicon-user"></span> دخول <b class="caret"></b>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="https://lammt.com/account/sign-in" title="تسجيل دخول">تسجيل
                                                    دخول</a></li>
                                            <li class="divider"></li>
                                            <li><a href="https://lammt.com/account/sign-up" title="تسجيل جديد">تسجيل
                                                    جديد</a></li>
                                        </ul>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <script>
        $(document).ready(function () {
            $(".header-menu").hover(
                function () {
                    $(this).find('.dropdown-menu').show();
                },
                function () {
                    $(this).find('.dropdown-menu').hide();
                }
            );
        });
    </script>
    @yield('content')
</div>
<footer class="footer">
    <div class="footer-newsletter">
        <div class="center-wrap">
            <h3>اشترك الآن في النشرة البريدية للفعاليات</h3>
            <div class="newsletter-first-block">
                <div>
                    <form action="https://lammt.com/" method="post" class="form-inline footer-newsletter-form">
                        <div class="form-group">
                            <div class="input-group newsletter-email-field">
                                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                <div class="input-group-input">
                                    <input type="text" name="newsletterEmail"
                                           class="form-control newsletter-email-input" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="اشترك" class="btn btn-newsletter">
                        <div class="newsletterResponse"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-wrap">
        <div class="center-wrap row">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12 footer-part-logo">
                    <img src="{{ asset('img/footer-logo.png') }}" alt="Lammt logo" title="Lammt logo">
                    <div class="footer-description">
                        الحقوق محفوظة - لمة 2015<br>حقوق الفعاليات محفوظة لمنظمي الفعاليات
                        <div class="footer-social-links">
                            <a href="http://www.facebook.com/LammtCom" target="_blank" title="Lammt on Facebook">
                                <span class="fa-stack fa-lg">
                                    <i class="fab fa-circle-thin fa-stack-2x"></i>
                                    <i class="fab fa-facebook fa-stack-1x"></i>
                                </span>
                            </a>
                            <a href="http://twitter.com/LammtCom" target="_blank" title="Lammt on Twitter">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle-thin fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x"></i>
                                </span>
                            </a>
                            <a href="http://instagram.com/LammtCom" target="_blank" title="Lammt on Instagram">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle-thin fa-stack-2x"></i>
                                    <i class="fa fa-instagram fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div>
                        <a href="https://lammt.com/account/sign-up?lang=en" class="footer-btn"
                           title="English">English</a>
                        <a href="https://lammt.com/account/sign-up?lang=ar" class="footer-btn"
                           title="العربية">العربية</a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 has-boredr">
                    <div class="footer-part-title">اكتشف لمة</div>
                    <ul class="fa-ul">
                        <li>
                            <i class="fa-li fa fa-chevron-left"></i>
                            <a href="https://lammt.com/" title="الرئيسية">الرئيسية</a>
                        </li>
                        <li>
                            <i class="fa-li fa fa-chevron-left"></i>
                            <a href="https://lammt.com/page/about" title="عن لمة">عن لمة</a>
                        </li>
                        <li>
                            <i class="fa-li fa fa-chevron-left"></i>
                            <a href="https://lammt.com/this-month" title="فعاليات الشهر">فعاليات الشهر</a>
                        </li>
                        <li>
                            <i class="fa-li fa fa-chevron-left"></i>
                            <a href="https://lammt.com/page/contact" title="تواصل معنا">تواصل معنا</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 has-boredr">
                    <div class="footer-part-title">استخدم لمة</div>
                    <ul class="fa-ul">
                        <li>
                            <i class="fa-li fa fa-chevron-left"></i>
                            <a href="https://lammt.com/pricing" title="أضف فعاليتك">أضف فعاليتك</a>
                        </li>
                        <li>
                            <i class="fa-li fa fa-chevron-left"></i>
                            <a href="https://lammt.com/page/partners" title="شركاؤنا">شركاؤنا</a>
                        </li>
                        <li>
                            <i class="fa-li fa fa-chevron-left"></i>
                            <a href="https://lammt.com/page/clients" title="عملاؤنا">عملاؤنا</a>
                        </li>
                        <li>
                            <i class="fa-li fa fa-chevron-left"></i>
                            <a href="https://lammt.com/page/privacy" title="شروط الاستخدام">شروط الاستخدام</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 has-boredr">
                    <div class="footer-part-title">تابع لمة</div>
                    <ul class="social-list">
                        <li>
                            <a href="http://www.facebook.com/LammtCom" target="_blank" title="Lammt on Facebook">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle-thin fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x"></i>
                                </span>
                                فيسبوك </a>
                        </li>
                        <li>
                            <a href="http://twitter.com/LammtCom" target="_blank" title="Lammt on Twitter">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle-thin fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x"></i>
                                </span>
                                تويتر </a>
                        </li>
                        <li>
                            <a href="http://instagram.com/LammtCom" target="_blank" title="Lammt on Instagram">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle-thin fa-stack-2x"></i>
                                    <i class="fa fa-instagram fa-stack-1x"></i>
                                </span>
                                انستاجرام </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>