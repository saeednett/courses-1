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

                    <form method="post" action="{{ route('center.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}


                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <input type="text" name="name"
                                       class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }} custom-input text-center"
                                       value="{{ old('name') }}" placeholder="اسم الجهة" maxlength="20" minlength="5" autocomplete="off" required>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">اسم الجهة</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <select class="custom-select {{ $errors->has('center_type') ? ' is-invalid' : '' }} custom-input"
                                        name="center_type" required>
                                    @if(old('center_type') != null)
                                        @if(old('center_type') == 1)
                                            <option value="1" selected>ربحي</option>
                                            <option value="0">غير ربحي</option>
                                        @else
                                            <option value="1">ربحي</option>
                                            <option value="0" selected>غير ربحي</option>
                                        @endif
                                    @else
                                        <option>- التصنيف -</option>
                                        <option value="1">ربحي</option>
                                        <option value="0">غير ربحي</option>
                                    @endif
                                </select>
                                @if ($errors->has('center_type'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('center_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">تصنيف الجهة</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center" id="verification_code">
                            <div class="col-lg-9">
                                <input type="text" name="verification_code"
                                       class="form-control {{ $errors->has('verification_code') ? ' is-invalid' : '' }} custom-input num text-center"
                                       value="{{ old('verification_code') }}" placeholder="رقم الترخيص"
                                       autocomplete="off" maxlength="10" minlength="4" required>
                                @if ($errors->has('verification_code'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('verification_code') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">رقم الترخيص</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center" id="verification_authority">
                            <div class="col-lg-9">
                                <input type="text" name="verification_authority"
                                       class="form-control {{ $errors->has('verification_authority') ? ' is-invalid' : '' }} custom-input text-center"
                                       value="{{ old('verification_authority') }}" placeholder="الجهة المرخصة"
                                       autocomplete="off" required>
                                @if ($errors->has('verification_authority'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('verification_authority') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">الجهة المرخصة</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <input type="text" name="phone"
                                       class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }} custom-input num-only text-center"
                                       value="{{ old('phone') }}" placeholder="رقم الهاتف" autocomplete="off"
                                       maxlength="10" minlength="10" required>
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

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <select class="custom-select{{ $errors->has('country') ? ' is-invalid' : '' }} custom-input"
                                        id="select-country" name="country" required>
                                    <option>- الدولة -</option>
                                    <?php $counter = 1; ?>
                                    @foreach($countries as $country)
                                        @if($counter == 1)
                                            <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                            <?php $counter++; ?>
                                        @else
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            <?php $counter++; ?>
                                        @endif
                                    @endforeach
                                </select>
                                @if ($errors->has('counter'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('counter') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">اسم الدولة</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <select class="custom-select {{ $errors->has('city') ? ' is-invalid' : '' }} custom-input"
                                        name="city" required>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('city'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">اسم المدينة</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <input type="text" name="website"
                                       class="form-control {{ $errors->has('website') ? ' is-invalid' : '' }} custom-input text-center"
                                       value="{{ old('website') }}" placeholder="الموقع الإلكتروني" autocomplete="off"
                                       s>
                                @if ($errors->has('website'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('website') }}</strong>
                                    </span>
                                @endif
                                <span class="text-muted text-center d-block" role="alert">
                                    <strong class="text-center">www.example.com :مثال</strong>
                                </span>
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label rtl">الموقع الإلكتروني</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center" id="bank">
                            <div class="col-lg-9">
                                <select class="custom-select {{ $errors->has('bank') ? ' is-invalid' : '' }} custom-input"
                                        name="bank" required>
                                    <option>- البنك -</option>
                                    @foreach($banks as $bank)
                                        @if($bank->id == old('bank'))
                                            <option value="{{ $bank->id }}" selected>{{ $bank->name }}</option>
                                        @else
                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                        @endif

                                    @endforeach
                                </select>
                                @if ($errors->has('bank'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('bank') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">اسم البنك</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center" id="account_owner">
                            <div class="col-lg-9">
                                <input type="text" name="account_owner"
                                       class="form-control {{ $errors->has('account_owner') ? ' is-invalid' : '' }} custom-input text-center"
                                       value="{{ old('account_owner') }}" placeholder="اسم صاحب الحساب"
                                       autocomplete="off" maxlength="50" minlength="10" required>
                                @if ($errors->has('account_owner'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('account_owner') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">اسم الحساب</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center" id="account_number">
                            <div class="col-lg-9">
                                <input type="text" name="account_number"
                                       class="form-control {{ $errors->has('account_number') ? ' is-invalid' : '' }} custom-input num-only text-center"
                                       value="{{ old('account_number') }}" placeholder="رقم الحساب | الايبان"
                                       autocomplete="off" maxlength="20" minlength="20" required>
                                @if ($errors->has('account_number'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('account_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">رقم الحساب</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <textarea
                                        class="form-control {{ $errors->has('about') ? ' is-invalid' : '' }} custom-textarea text-center"
                                        name="about" cols="5" rows="6" placeholder="نبذة عن الجهة" autocomplete="off"
                                        required>{{ old('about') }}</textarea>
                                @if ($errors->has('about'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('about') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">نبذة عن الجهة</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-9">
                                <input type="text" id="profile-logo"
                                       class="form-control {{ $errors->has('profile-logo') ? ' is-invalid' : '' }} custom-input text-center"
                                       value="{{ old('profile-logo') }}" placeholder="الصورة الشخصية" autocomplete="off"
                                       readonly required>
                                @if ($errors->has('profile-logo'))
                                    <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('profile-logo') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-lg-3 text-center pt-2">
                                <label class="col-form-label required-field rtl">الصورة الشخصية</label>
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-lg-6 text-center">
                                <input type="file" name="profile-image" class="op-0"  accept="image/png">
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

            <div class="row justify-content-center mt-2">
                <div class="col-lg-2 col-md-2 col-sm-5 col-5">
                    <a href="a">
                        <img class="d-block m-auto p-2" src="{{ asset('img/main/logo.png') }}" height="80">
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

<script src="{{ asset('js/center/register.js') }}"></script>
</body>
</html>