@extends('student.master-v-1-1')

@section('title', 'تسجيل مستخدم جديد')

@section('guest-links')
    <a class="dropdown-item" href="{{ route('account.register') }}">تسجيل مستخدم جديد</a>
@endsection

@section('content')
    <div class="wrap">
        <div class="container">
            <div class="row justify-content-center mt-4">

                <div class="col-lg-4 order-lg-first order-last mt-lg-5 mb-4 align-self-start sticky-top">
                    <div class="block rounded text-right">
                        <p class="rtl">فريق خدمة العملاء جاهز دائماً للمساعدة.</p>
                        <p class="rtl"> اتصل بنا: <b>0592970476</b> </p>
                        <p class="rtl"> او راسلنا: <b>soao_d@hotmail.com</b></p>
                    </div>
                </div>

                <div class="col-lg-6 col-mg-8">
                    <form action="{{ route('account.password') }}" class="form-horizontal" method="post"
                          accept-charset="utf-8">
                        {{ csrf_field() }}
                        <fieldset>
                            <h1 class="text-right">تغيير الرقم السري</h1>

                            @if(session()->has('success'))
                                <div class="alert alert-success mt-4">
                                    <ul class="text-right mb-0 rtl">
                                        <li>{{ session('success') }}</li>
                                    </ul>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger mt-4">
                                    <ul class="text-right mb-0 rtl">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="block rounded">
                                <p class="text-right rtl">لحفظ بياناتك ننصحك باختيار رقم سري صعب التوقع ونقترح عليك مايلي...</p>
                                <ol class="text-right rtl">
                                    <li>على الأقل مكون من 6 خانات وكلما زاد  العدد كلما كان أصعب</li>
                                    <li>يحتوي على حروف كبيرة وصغيرة باللغة الإنجليزية</li>
                                    <li>يحتوي على أرقام ورموز لايمكن توقعها</li>
                                    <li>لايعتمد على معلومة من معلوماتك الشخصية</li>
                                    <li>لايعتمد على كلمة في القاموس لسهولة توقعها</li>
                                </ol>
                            </div>

                            <div class="block rounded">
                                <div class="form-group row justify-content-center">
                                    <div class="col-lg-10 col-md-10 col-sm-12 col-12 m-auto text-right">
                                        <label class="col-form-label required-field rtl" for="reset_password_old_password">كلمة المرور القديمة</label>
                                    </div>

                                    <div class="col-lg-12 controls">
                                        <input type="password" name="old_password" value="{{ old('old_password') }}" id="reset_password_old_password"
                                               class="form-control col-lg-10 col-md-10 col-sm-12 col-12 m-auto {{ $errors->has('old_password') ? ' is-invalid' : '' }} form-control-sm text-center"
                                               required
                                               autocomplete="off">
                                        @if ($errors->has('old_password'))
                                            <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center">
                                    <div class="col-lg-10 col-md-10 col-sm-12 col-12 m-auto text-right">
                                        <label class="col-form-label required-field rtl" for="reset_password_new_password">كلمة المرور الجديدة</label>
                                    </div>

                                    <div class="col-lg-12 controls">
                                        <input type="password" name="password" id="reset_password_new_password"
                                               class="form-control col-lg-10 col-md-10 col-sm-12 col-12 m-auto {{ $errors->has('password') ? ' is-invalid' : '' }} form-control-sm text-center"
                                               required
                                               autocomplete="off">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center">
                                    <div class="col-lg-10 col-md-10 col-sm-12 col-12 m-auto text-right">
                                        <label class="col-form-label required-field rtl" for="reset_password_password_confirmation">تأكيد المرور</label>
                                    </div>

                                    <div class="col-lg-12">
                                        <input type="password" name="password_confirmation" id="reset_password_password_confirmation"
                                               class="form-control col-lg-10 col-md-10 col-sm-12 col-12 m-auto {{ $errors->has('password') ? ' is-invalid' : '' }} form-control-sm text-center"
                                               required
                                               autocomplete="off">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn custom-btn">تغير كلمة المرور</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection