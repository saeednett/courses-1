<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    @yield('mete')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Tajawal" rel="stylesheet">
    <link href="{{ asset('css/student/bootstrap-chosen.css') }}" rel="stylesheet">
    <link href="{{ asset('css/student/index.css') }}" rel="stylesheet">
    @yield('style-file')

</head>
<body>

<div class="wrap">

    <header class="header">

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12 col-12">
                    <div class="row justify-content-end">
                        <div class="col-lg-9 col-md-8 col-sm-12 col-12">
                            <nav class="navbar navbar-expand-lg navbar-light">

                                <a class="navbar-brand preview rtl" href="#">
                                    <div class="row">
                                        <div class="col-4">
                                            <img src="{{ asset('img/admin/logo.png') }}" alt="" height="70"
                                                 width="50">
                                        </div>
                                        <div class="col-8">
                                            <form class="text-center" style="margin-top: 25px;" action="" method="post">
                                                <select data-placeholder=""
                                                        class="chosen-select col-lg-12 col-md-8 col-sm-12 col-12">
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
                                        </div>
                                    </div>
                                </a>

                                <button class="navbar-toggler d-lg-none d-md-none d-sm-block d-block" type="button"
                                        data-toggle="collapse"
                                        data-target="#navbarSupportedContent"
                                        aria-controls="navbarSupportedContent" aria-expanded="false"
                                        aria-label="{{ __('Toggle navigation') }}">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <!-- Left Side Of Navbar -->
                                    <ul class="navbar-nav d-lg-none d-md-block d-sm-block d-block">
                                        <li class="nav-item tap-link">
                                            <a class="nav-link preview" href="#">الرئسية</a>
                                        </li>

                                        <li class="nav-item tap-link">
                                            <a class="nav-link preview" href="#">من نحن</a>
                                        </li>

                                        <li class="nav-item tap-link">
                                            <a class="nav-link preview" href="#">اتصل بنا</a>
                                        </li>
                                    </ul>

                                    <ul class="navbar-nav d-lg-none d-md-none d-sm-block d-block"
                                        style="direction: ltr;">
                                        <!-- Authentication Links -->
                                        <li class="nav-item dropdown tap-link text-center"
                                            style="display: block; text-align: left; direction: rtl;">
                                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#"
                                               role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                دخول
                                                <span class="fa fa-user"></span>
                                                <span class="caret"></span>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right text-right"
                                                 aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item preview" href="#">تسجيل الدخول</a>
                                                <a class="dropdown-item preview" href="#">تسجيل مستخدم جديد</a>
                                            </div>
                                        </li>
                                    </ul>

                                </div>
                            </nav>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-12 col-12 d-lg-block d-md-block d-sm-none d-none">
                            <button class="btn btn-outline-success" style="margin-top: 40px;">أضف فعاليتك الآن!</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="menu-section d-lg-block d-md-block d-sm-none d-none">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10 col-sm-12 col-12">

                        <nav class="navbar navbar-expand-lg navbar-expand-md navbar-light d-lg-flex d-md-flex d-sm-none d-none">

                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav">
                                <li class="nav-item tap-link">
                                    <a class="nav-link preview" href="#">الرئسية</a>
                                </li>

                                <li class="nav-item tap-link">
                                    <a class="nav-link preview" href="#">من نحن</a>
                                </li>

                                <li class="nav-item tap-link">
                                    <a class="nav-link preview" href="#">اتصل بنا</a>
                                </li>

                                <li class="nav-item tap-link">
                                    <a class="nav-link preview rtl" href="#">
                                        تذاكري
                                    </a>
                                </li>
                            </ul>


                            <ul class="navbar-nav" style="direction: ltr;">
                                <!-- Authentication Links -->
                                <li class="nav-item dropdown"
                                    style="display: block; text-align: left; direction: rtl;">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        دخول
                                        <span class="fa fa-user"></span>
                                        <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right text-right"
                                         aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item preview" href="#">تسجيل الدخول</a>
                                        <a class="dropdown-item preview" href="#">تسجيل مستخدم جديد</a>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

        </div>
    </header>

    @yield('content')

    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h5>اشترك الآن في النشرة البريدية للدورات</h5>
                </div>
            </div>
            <div class="row justify-content-center mt-2">
                <div class="col-lg-4 col-md-6 col-sm-10">

                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm text-center"
                               placeholder="البريد الإلكتروني"
                               aria-label="Username">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row justify-content-center mt-2">
                <div class="col-lg-4 col-md-6 col-sm-12 text-center">
                    <button class="btn btn-success preview">اشتراك</button>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center">
                    <h5>تابعنا على مواقع انواصل</h5>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-2 col-sm-4 col-6">
                    <div class="row justify-content-center">

                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 text-center">
                            <span class="fa-stack">
                                <i class="fa fa-circle-thin fa-stack-2x"></i>
                                <i class="fa fa-twitter fa-stack-1x"></i>
                            </span>
                        </div>

                        <div class="col-lg-3 col-md-2 col-sm-3 col-3 text-center" style=" border-left:1px white solid;">
                            <span class="fa-stack">
                                <i class="fa fa-circle-thin fa-stack-2x"></i>
                                <i class="fa fa-facebook fa-stack-1x"></i>
                            </span>
                        </div>

                        <div class="col-lg-3 col-md-2 col-sm-3 col-3 text-center" style=" border-left:1px white solid;">
                            <span class="fa-stack">
                                <i class="fa fa-circle-thin fa-stack-2x"></i>
                                <i class="fa fa-snapchat fa-stack-1x"></i>
                            </span>
                        </div>

                        <div class="col-lg-3 col-md-2 col-sm-3 col-3 text-center" style=" border-left:1px white solid;">
                            <span class="fa-stack">
                                <i class="fa fa-circle-thin fa-stack-2x"></i>
                                <i class="fa fa-instagram fa-stack-1x"></i>
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-3 mb-3">
                <div class="col-lg-2 col-md-2 col-sm-5 col-5">
                    <a class="preview" href="#"><img class="m-auto d-block" src="{{ asset('img/admin/logo.png') }}" width="70"> </a>
                </div>
            </div>

            <div class="row justify-content-center pt-lg-0 pt-1">
                <div class="col-lg-5 col-md-5 col-sm-5 col-11 text-center">
                    <p>الحقوق محفوظة - لورد 2015
                        حقوق الدورات محفوظة لمنظمي الدورات</p>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
<script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
@yield('script-file')
<script>
    $(document).ready(function () {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
    });
</script>
</body>
</html>