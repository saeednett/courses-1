@extends('student.layouts.master-v-1-1')

@section('title', 'تواصل معنا')

@section('guest-links')
    <a class="dropdown-item" href="{{ route('account.login') }}">تسجيل الدخول</a>
    <a class="dropdown-item" href="{{ route('account.register') }}">تسجيل مستخدم جديد</a>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/student/contact-us.css') }}">
@endsection

@section('content')
    <div class="wrap">
        <div class="container">
            <div class="row justify-content-center mt-3">

                <div class="col-lg-4 col-md-4 col-sm-12 col-12 order-lg-first order-md-first order-sm-last order-last mt-lg-5 mt-md-5 mt-0 mb-4 align-self-start sticky-top">
                    <div class="block rounded text-right">
                        <p class="rtl">فريق خدمة العملاء جاهز دائماً للمساعدة.</p>
                        <p class="rtl"> اتصل بنا: <b>0592970476</b></p>
                        <p class="rtl"> او راسلنا: <b>soao_d@hotmail.com</b></p>
                    </div>

                    <div class="block rounded text-right">
                        <p>تابعنا في الشبكات الاجتماعية</p>
                        <div class="profile-social-media-accounts">
                            <ul class="nav profile-social-media p-0 rtl">
                                <li>
                                    <a class="social social-twitter" href=href="http://twitter.com/breakoutksa"></a>
                                </li>
                                <li>
                                    <a class="social social-facebook" href=href="http://twitter.com/breakoutksa"></a>
                                </li>
                                <li>
                                    <a class="social social-snapchat" href=href="http://twitter.com/breakoutksa"></a>
                                </li>
                                <li>
                                    <a class="social social-twitter" href=href="http://twitter.com/breakoutksa"></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-8 col-sm-12 col-12">
                    <h1 class="text-lg-right text-md-right text-center d-lg-block d-md-block d-none">قالب التواصل</h1>
                    <h3 class="text-lg-right text-md-right mt-md-4 mt-4 text-center d-lg-none d-md-none d-block">قالب
                        التواصل</h3>

                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            <ul class="text-right mb-0 rtl">
                                <li>{{ session('success') }}</li>
                            </ul>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="text-right mb-0 rtl">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="block rounded mb-lg-5 mb-md-5 mb-0">

                        <form method="post" action="{{ route('account.contact_us.confirm') }}" class="mb-0">
                            {{ csrf_field() }}

                            <div class="well text-center rtl">من هنا يمكنك التواصل مع إدارة الموقع في أي وقت</div>

                            <div class="row justify-content-center">
                                <div class="col-lg-4">
                                    <img src="{{ asset('img/main/logo.png') }}" class="h-30 w-100">
                                </div>
                            </div>

                            <div class="mt-4">

                                <div class="form-group row mt-4">
                                    <div class="col-lg-12 text-right rtl">
                                        <label class="col-form-label required-field">الموضوع</label>
                                        <input type="text"
                                               class="form-control {{ $errors->has('subject') ? ' is-invalid' : '' }} text-center form-control-sm"
                                               name="subject"
                                               value="{{ old('subject') }}" required autocomplete="off">
                                        @if ($errors->has('subject'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('subject') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-lg-12 text-right rtl">
                                        <label class="col-form-label required-field">الاسم</label>
                                        <input type="text"
                                               class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }} text-center form-control-sm"
                                               name="name"
                                               value="{{ old('name') }}" required autocomplete="off">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-lg-12 text-right rtl">
                                        <label class="col-form-label required-field">رقم الهاتف</label>
                                        <input type="text"
                                               class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }} text-center form-control-sm"
                                               name="phone"
                                               value="{{ old('phone') }}" required autocomplete="off">
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mt-4">
                                    <div class="col-lg-12 text-right rtl">
                                        <label class="col-form-label required-field">البريد الإلكتروني</label>
                                        <input type="email"
                                               class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }} text-center form-control-sm"
                                               name="email"
                                               value="{{ old('email') }}" required autocomplete="off">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row mt-4">
                                    <div class="col-lg-12 text-right rtl">
                                        <label class="col-form-label required-field">النص</label>
                                        <textarea class="form-control no-resize {{ $errors->has('message') ? ' is-invalid' : '' }} text-center"
                                               name="message" cols="6" rows="8" required autocomplete="off">{{ old('message') }}</textarea>
                                        @if ($errors->has('message'))
                                            <span class="invalid-feedback text-center" role="alert">
                                                <strong>{{ $errors->first('message') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row mb-0">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn custom-btn">إرسال</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection