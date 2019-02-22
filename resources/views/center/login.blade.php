<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    @yield('mete')
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>تسجبل الدخول</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Tajawal" rel="stylesheet">

    <style>
        body {
            width: 100%;
            background: #f8f8f8;
            font-family: 'Tajawal', sans-serif;
        }

        .wrap {
            min-height: 100%;
            min-width: 100%;
        }

        .block {
            border-radius: 10px;
            background: #FFF;
            border: 1px solid #ccc;
            font-weight: 400;
            margin-top: 15px;
            padding: 20px;
            margin-bottom: 15px;
        }

        .required-field:after {
            color: #ff6771;
            content: " *";
            text-align: right;
        }

        .rtl {
            direction: rtl;
        }

        .custom-btn {
            height: 60px;
            border-radius: 30px;
            background-image: linear-gradient(to right, #1bc3a1 0%, #6fcf8f);
            display: block;
            border: none;
            font-size: 18px;
            color: #fff;
        }

        .custom-btn:hover {
            box-shadow: 0 4px 10px 0 rgba(11, 121, 99, 0.31);
        }

        .custom-input {
            height: 50px;
            border-radius: 30px;
            border: 1px solid rgba(34, 36, 38, .15);
        }

        .custom-input:hover {
            border: 2px solid #1bc3a1;
        }

        .custom-input:focus {
            box-shadow: none !important;
            border: 2px solid #1bc3a1;
        }

        select {
            direction: rtl !important;
            text-align: center !important;
            text-align-last: center !important;
        }

        .footer {
            height: 380px;
            margin-top: 0;
            width: 100%;
            padding-top: 20px;
            background-image: linear-gradient(to right, #1bc3a1 0%, #6fcf8f);
            font-size: 12px;
            font-weight: 400;
            color: #ecf4e0;
            z-index: 2500;
        }
    </style>
</head>
<body>

<div class="wrap">
    <header style="background: #1bc3a1; direction: rtl;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <nav class="navbar navbar-expand-lg navbar-dark align-self-start sticky-top"
                         style="background: #6fcf8f;">

                        {{--<img class="navbar-brand" src="{{ asset('img/center/logo.png') }}" alt="" height="70">--}}

                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="login-option"
                                       role="button" data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false" style="color: #005872;">
                                        <span>الدخول</span>
                                        <i class="fa fa-user"></i>
                                    </a>
                                    <div class="dropdown-menu text-center" aria-labelledby="login-option">
                                        <a class="dropdown-item" href="{{ route('center.register') }}">تسجيل جديد</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">نسيت كلمة المرور</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>


    <div style="background-image: linear-gradient(to right, #1bc3b9 0%, #ffe347), linear-gradient(#ffffff, #ffffff); transform: rotate(-142deg); width: 994.7px; height: 698.1px; position: fixed; right: -547px; z-index: 100; top: -301px; opacity: 0.5;"></div>
    <div style="transform: rotate(57deg);background-image: linear-gradient(to right, #1bc3a1 0%, #6fcf8f); box-shadow: 0 4px 10px 0 rgba(11, 121, 99, 0.31); width: 555.1px; height: 1323.6px; position: fixed; border-top-right-radius: 140px; left: -682px; z-index: 0; top: 40%; opacity: 0.7;"></div>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-lg-7">

                <h1 class="text-right">تسجيل الدخول</h1>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="text-right rtl mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="block mt-0">

                    <form method="post" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <input type="text" name="username"
                                       class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }} custom-input text-center"
                                       value="{{ old('username') }}" placeholder="اسم المستخدم" autocomplete="off"
                                       required>
                                @if ($errors->has('username'))
                                    <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center">
                                <label class="col-form-label required-field rtl">اسم المستخدم</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <input type="password" name="password"
                                       class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} custom-input text-center"
                                       placeholder="كلمة المرور" autocomplete="off" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center">
                                <label class="col-form-label required-field rtl">كلمة المرور</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-8">
                                <button class="btn col-lg-8 custom-btn">تسجيل</button>
                                <p class="col-lg-8 mt-2 text-right rtl"><span>ليس لديك حساب؟</span> <a
                                            href="{{ route('center.register') }}"> تسجيل جديد</a></p>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="footer mt-5 d-none">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h5>اشترك الآن في النشرة البريدية للفعاليات</h5>
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
                    <button class="btn btn-success">اشتراك</button>
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

            <div class="row justify-content-center mt-4">
                <div class="col-lg-2 col-md-2 col-sm-5 col-5">
                    <a href="#">
                        <img src="{{ asset('img/center/logo.png') }}" alt="logo">
                    </a>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-5 col-sm-5 col-10 text-center">
                    <p>الحقوق محفوظة - لمة 2015
                        حقوق الفعاليات محفوظة لمنظمي الفعاليات</p>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>


<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>

<script>
    $(document).ready(function () {
        $(document).on("keypress", '.num-only', function (evt) {
            let charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        });


        $('select[name=country]').on('change', function () {
            var country = $(this).val();
            $.ajax({
                url: "http://127.0.0.1:8000/api/v-1/cities/country=" + country,
                type: "get",
                success: function (data, result) {
                    $('select[name=city]').children().remove();
                    for (let i = 0; i < data['data'].length; i++) {
                        $('select[name=city]').append("<option value='" + data['data'][i]['id'] + "'>" + data['data'][i]['name'] + "</option>");
                    }
                },
                error: function () {
                    alert("هناك خطأ الرجاء المحاولة لاحقا");
                }
            });
        });


    });
</script>
</body>
</html>