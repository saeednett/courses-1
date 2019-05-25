@extends('student.layouts.master-v-1-1')

@section('title', 'تسجيل مستخدم جديد')

@section('guest-links')
    <a class="dropdown-item" href="{{ route('account.register') }}">تسجيل مستخدم جديد</a>
@endsection

@section('content')
    <div class="wrap">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-5">
                    <form action="{{ route('login') }}" class="form-horizontal" method="post"
                          accept-charset="utf-8">
                        {{ csrf_field() }}
                        <fieldset>
                            <h1 class="text-right">دخول بالحساب</h1>

                            <div class="block">
                                <div class="form-group row justify-content-center">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                                        <label class="col-form-label required-field rtl" for="sign_in_username">
                                            اسم المستخدم</label>
                                    </div>

                                    <div class="col-lg-12 controls">
                                        <input type="text" name="username" value="{{ old('username') }}" id="sign_in_username"
                                               class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }} form-control-sm text-center"
                                               required
                                               autocomplete="off">
                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row justify-content-center">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                                        <label class="col-form-label required-field rtl"
                                               for="sign_up_phone">كامة المرور</label>
                                    </div>

                                    <div class="col-lg-12">
                                        <input type="password"
                                               class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} form-control-sm text-center"
                                               name="password" value="{{ old('password') }}" autocomplete="off">
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
                                    <button type="submit" class="btn custom-btn">دخول</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-xs-6 col-6 text-right">
                                    غير مسجل ؟
                                    <a href="{{ route('account.register') }}" title="تسجيل جديد">تسجيل جديد</a>
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-6 col-6 text-left order-first">
                                    <a href="#" title="نسيت كلمة المرور">نسيت كلمة المرور</a>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection