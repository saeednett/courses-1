@extends('student.master-v-1-1')

@section('title', 'تسجيل مستخدم جديد')

@section('guest-links')
    <a class="dropdown-item" href="{{ route('account.login') }}">تسجيل الدخول</a>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-lg-4 order-lg-first order-last mt-lg-5 mb-4 align-self-start sticky-top">
                <div class="block rounded text-right">
                    <p class="rtl">فريق خدمة العملاء جاهز دائماً للمساعدة.</p>
                    <p class="rtl"> اتصل بنا: <b>0592970476</b> </p>
                    <p class="rtl"> او راسلنا: <b>soao_d@hotmail.com</b></p>
                </div>
            </div>
            <div class="col-lg-6">
                <form action="{{ route('account.store') }}" class="form-horizontal" method="post"
                      accept-charset="utf-8">
                    {{ csrf_field() }}
                    <fieldset>
                        <h1 class="text-lg-right text-center">إنشاء حساب جديد</h1>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="text-right rtl mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="block rounded">

                            <div class="form-group row justify-content-center">
                                <div class="col-lg-10 col-md-10 col-sm-12 col-12 text-right">
                                    <label class="col-form-label required-field rtl" for="sign_up_name">
                                        الاسم الكامل </label>
                                </div>

                                <div class="col-lg-10 controls">
                                    <input type="text" name="name" value="{{ old('name') }}" id="sign_up_name"
                                           class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }} form-control-sm text-center" required
                                           autocomplete="off">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-lg-10 col-md-10 col-sm-12 col-12 text-right">
                                    <label class="col-form-label required-field rtl"
                                           for="sign_up_phone">رقم الجوال</label>
                                </div>

                                <div class="col-lg-10 text-center">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text form-control-sm">+966</span>
                                        </div>
                                        <input type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }} form-control-sm text-center" name="phone" value="{{ old('phone') }}" autocomplete="off">
                                    </div>
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                    @else
                                        <small class="text-center text-muted">الرجاء الابتداء برمز الدولة.. +966</small>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-lg-10 col-md-10 col-sm-12 col-12 text-right">
                                    <label class="col-form-label required-field rtl" for="sign_up_username">اسم المستخدم</label>
                                </div>


                                <div class="col-lg-10">
                                    <input type="text" name="username" value="{{ old('username') }}"
                                           id="sign_up_username" maxlength="20"
                                           class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }} form-control-sm text-center"
                                           required autocomplete="off">
                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-lg-10 col-md-10 col-sm-12 col-12 text-right">
                                    <label class="col-form-label required-field rtl" for="sign_up_country">الدولة</label>
                                </div>


                                <div class="col-lg-10">
                                    <select class="custom-select {{ $errors->has('country') ? ' is-invalid' : '' }}" name="country" required>
                                        @foreach($countries as $country)
                                            @if(old('country') == $country->id)
                                                <option value="{{ $country->id }}" selected>{{ $country->name }}</option>
                                            @else
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group row justify-content-center">
                                <div class="col-lg-10 col-md-10 col-sm-12 col-12 text-right">
                                    <label class="col-form-label required-field rtl" for="sign_up_city">المدينة</label>
                                </div>
                                <div class="col-lg-10">
                                    <select class="custom-select {{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" required>
                                        @foreach($cities as $city)
                                            @if(old('city') == $city->id)
                                                <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                                            @else
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>



                            <div class="form-group row justify-content-center">
                                <div class="col-lg-10 col-md-10 col-sm-12 col-12 text-right">
                                    <label class="col-form-label required-field rtl" for="sign_up_email">البريد الإلكتروني</label>
                                </div>

                                <div class="col-lg-10">
                                    <input type="text" name="email" value="{{ old('email') }}" id="sign_up_email"
                                           maxlength="100"
                                           class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }} form-control-sm text-center"
                                           required autocomplete="off">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-lg-10 col-md-10 col-sm-12 col-12 text-right">
                                    <label class="col-form-label required-field rtl" for="sign_up_password">الرقم السري </label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="password" name="password" id="sign_up_password"
                                           class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} form-control-sm text-center"
                                           required autocomplete="off">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-lg-10 col-md-10 col-sm-12 col-12 text-right">
                                    <label class="required-field rtl"
                                           for="sign_up_password_confirmation">تأكيد الرقم السري</label>
                                </div>

                                <div class="col-lg-10">
                                    <input type="password" name="password_confirmation"
                                           id="sign_up_password_confirmation"
                                           class="form-control form-control-sm text-center" required autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-lg-10 col-md-10 col-sm-12 col-12 text-right">
                                    <label class="col-form-label text-right required-field rtl">
                                        الجنس
                                    </label>
                                </div>

                                <div class="col-lg-10 text-right">
                                    <div class="text-right">
                                        <label class="form-check-label mr-4" for="male">ذكر</label>
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="1" checked>
                                    </div>

                                    <div class="text-right mt-0">
                                        <label class="form-check-label mr-4" for="female">أنثى</label>
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn custom-btn"> إنشاء حسابي</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                مسجل مسبقاً؟<a href="{{ route('account.login') }}" title="تسجيل دخول الآن">تسجيل دخول الآن</a>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection