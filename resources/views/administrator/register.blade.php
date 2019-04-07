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
    <link href="{{ asset('css/center/register.css') }}" rel="stylesheet">
</head>
<body>

<div class="wrap">
    <header>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <nav class="navbar navbar-expand-lg navbar-dark align-self-start sticky-top">
                        <img class="navbar-brand" src="{{ asset('img/center/logo.png') }}" alt="" height="70">
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle c005872" href="#" id="login-option"
                                       role="button" data-toggle="dropdown" aria-haspopup="true"
                                       aria-expanded="false">
                                        <span>الدخول</span>
                                        <i class="fa fa-user"></i>
                                    </a>
                                    <div class="dropdown-menu text-center" aria-labelledby="login-option">
                                        <a class="dropdown-item" href="{{ route('center.login') }}">تسجيل الدخول</a>
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


    <div class="top-div"></div>
    <div class="bottom-div"></div>

    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-lg-7">

                <h1 class="text-right">تسجيل جديد</h1>

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

                    <form method="post" action="{{ route('administrator.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <input type="text" name="name"
                                       class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }} custom-input text-center"
                                       value="{{ old('name') }}" placeholder="الإسم" autocomplete="off"
                                       maxlength="50" minlength="7" required>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">الإسم</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <input type="text" name="phone"
                                       class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }} custom-input num-only text-center"
                                       value="{{ old('phone') }}" placeholder="رقم الهاتف" autocomplete="off"
                                       maxlength="9" minlength="9" required>
                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">رقم الهاتف</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <input type="email" name="email"
                                       class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }} custom-input text-center"
                                       value="{{ old('email') }}" placeholder="البريد الإلكتروني" autocomplete="off"
                                       required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">البريد الإلكتروني</label>
                            </div>
                        </div>

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
                            <div class="col-lg-3 text-center pt-2">
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
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">كلمة المرور</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <input type="password" name="password_confirmation"
                                       class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} custom-input text-center"
                                       placeholder="تأكيد كلمة المرور" autocomplete="off" required>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">تأكيد كلمة المرور</label>
                            </div>
                        </div>


                        <div class="dropdown-divider mt-2 mb-5"></div>

                        <div class="form-group row justify-content-start">
                            <div class="col-lg-9">
                                <button class="btn btn-block custom-btn">تسجيل</button>
                                <p class="mt-2 pr-2 text-right rtl"><span>هل لديك حساب؟</span> <a
                                            href="{{ route('center.login') }}"> تسجيل الدخول</a></p>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="footer mt-5">
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

                        <div class="col-lg-3 col-md-2 col-sm-3 col-3 text-center border-left-1">
                            <span class="fa-stack">
                                <i class="fa fa-circle-thin fa-stack-2x"></i>
                                <i class="fa fa-facebook fa-stack-1x"></i>
                            </span>
                        </div>

                        <div class="col-lg-3 col-md-2 col-sm-3 col-3 text-center border-left-1">
                            <span class="fa-stack">
                                <i class="fa fa-circle-thin fa-stack-2x"></i>
                                <i class="fa fa-snapchat fa-stack-1x"></i>
                            </span>
                        </div>

                        <div class="col-lg-3 col-md-2 col-sm-3 col-3 text-center border-left-1">
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
                    <a href="a"><img src="{{ asset('img/center/logo.png') }}" height="70"> </a>
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

<script src="{{ asset('js/center/register.js') }}"></script>
</body>
</html>