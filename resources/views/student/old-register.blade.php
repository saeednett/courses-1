@extends('student.layouts.master')

@section('title', 'تسجيل مستخدم جديد')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="{{ route('account.store') }}" class="form-horizontal" method="post"
                      accept-charset="utf-8">
                    {{ csrf_field() }}
                    <fieldset>
                        <h1 class="text-center">إنشاء حساب جديد</h1>

                        <div class="block">

                            <div class="form-group ">
                                <label class="col-md-12 control-label text-left required-field" for="sign_up_name">
                                    الاسم الكامل </label>

                                <div class="col-md-12 controls">
                                    <input type="text" name="name" value="{{ old('name') }}" id="sign_up_name"
                                           class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" required
                                           autocomplete="off">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col-md-12 custom-control-label text-right required-field"
                                       for="sign_up_phone">
                                    رقم الجوال </label>

                                <div class="col-md-12 controls">
                                    <div class="input-group phone-input-group-ar">
                                        <span class="input-group-addon">+966</span>
                                        <input type="text"
                                               class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                               name="phone" value="{{ old('phone') }}"
                                               id="sign_up_phone" maxlength="10" minlength="9" required
                                               autocomplete="off">
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col-md-12 control-label text-left required-field" for="sign_up_username">اسم
                                    المستخدم</label>

                                <div class="col-md-12 controls">
                                    <input type="text" name="username" value="{{ old('username') }}"
                                           id="sign_up_username" maxlength="20"
                                           class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}"
                                           required autocomplete="off">
                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col-md-12 control-label text-left required-field" for="sign_up_email">
                                    البريد الإلكتروني </label>

                                <div class="col-md-12 controls">
                                    <input type="text" name="email" value="{{ old('email') }}" id="sign_up_email"
                                           maxlength="100"
                                           class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           required autocomplete="off">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col-md-12 control-label text-left required-field" for="sign_up_password">
                                    الرقم السري </label>

                                <div class="col-md-12 controls">
                                    <input type="password" name="password" id="sign_up_password"
                                           class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           required autocomplete="off">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group ">
                                <label class="col-md-12 control-label text-left required-field"
                                       for="sign_up_password_confirmation">تأكيد الرقم السري</label>

                                <div class="col-md-12 controls">
                                    <input type="password" name="password_confirmation"
                                           id="sign_up_password_confirmation"
                                           class="form-control" required autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-12 control-label text-left required-field">
                                    الجنس
                                </label>

                                <div class="col-md-12">
                                    <label class="radio">
                                        <input type="radio" name="gender" value="1" checked="checked">ذكر
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="gender" value="2">أنثى </label>
                                    @if ($errors->has('gender'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('gender') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn sp-book-now"> إنشاء حسابي</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                مسجل مسبقاً؟ <a href="https://lammt.com/account/sign-in" title="تسجيل دخول الآن">تسجيل دخول الآن</a>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection