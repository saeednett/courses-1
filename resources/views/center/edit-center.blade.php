@extends('center.layouts.master-v-1-1')

@section('main-title', "تعديل المعلومات الشخصية")

@section('page-links')
    <li><a href="index.html"><i class="fa fa-user"></i>الملف الشخص</a></li>
    <li class="active"><a href="form-basic.html">بياناتي الشخصية</a></li>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/plugins/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/center/edit-center.css') }}">
@endsection

@section('content')
    <div class="row">
        @if($errors->any())
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        @endif

        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">

                <div class="panel-heading clearfix">
                    {{--<h3 class="panel-title">Basic Form</h3>--}}
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                        <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                    </ul>
                </div>

                <div class="panel-body">

                    <form method="post" action="{{ route('center.update') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="required-field rtl" for="name">اسم المركز</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }} custom-input text-center ltr"
                                           name="name" id="name" value="{{ $user->center->name }}"
                                           autocomplete="off" required>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="required-field rtl" for="phone">رقم الهاتف</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }} custom-input num-only text-center ltr"
                                           name="phone" id="phone" value="{{ $user->phone }}" maxlength="13" minlength="9" required>
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="required-field" for="email">البريد الإلكتروني</label>
                                    <input type="email"
                                           class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }} custom-input text-center ltr"
                                           name="email" id="email" value="{{ $user->email }}" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group {{ $errors->has('username') ? ' has-error has-feedback' : '' }}">
                                    <label class="required-field" for="username">اسم المستخدم</label>
                                    <input type="text"
                                           class="form-control custom-input text-center ltr"
                                           name="username" id="username" value="{{ $user->username }}" required>
                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="required-field" for="verification_code">رقم الترخيص</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('verification_code') ? ' is-invalid' : '' }} custom-input num-only text-center ltr"
                                           name="verification_code" id="verification_code"
                                           value="{{ $user->center->verification_code }}" maxlength="10" required>
                                    @if ($errors->has('verification_code'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('verification_code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="required-field" for="verification_authority">الجهة المرخصة</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('verification_authority') ? ' is-invalid' : '' }} custom-input text-center ltr"
                                           name="verification_authority" id="verification_authority"
                                           value="{{ $user->center->verification_authority }}" required>
                                    @if ($errors->has('verification_authority'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('verification_authority') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="required-field" for="country">الدولة</label>
                                    <select class="form-control select2-placeholer {{ $errors->has('country') ? ' is-invalid' : '' }}"
                                            name="country" required>
                                        @foreach($countries as $country)
                                            @if($user->center->city->country->id == $country->id)
                                                <option value="{{ $country->id }}"
                                                        selected>{{ $country->name }}</option>
                                            @else
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('country') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="city" class="required-field">المدينة</label>
                                    <select id="city" class="form-control select2-placeholer {{ $errors->has('city') ? ' is-invalid' : '' }}"
                                            name="city" required>
                                        @foreach($cities as $city)
                                            @if($user->center->city_id == $city->id)
                                                <option value="{{ $city->id }}" selected>{{ $city->name }}</option>
                                            @else
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('city'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="" for="website">الموقع الاإلكتروني</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('website') ? ' is-invalid' : '' }} custom-input text-center ltr"
                                           name="website" id="website"
                                           value="{{ $user->center->website }}" autocomplete="off">
                                    @if ($errors->has('website'))
                                        <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('website') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="profile-cover">صورة الغلاف</label>
                                    <input type="text" id="profile-cover" class="form-control {{ $errors->has('profile-cover') ? ' is-invalid' : '' }} custom-input text-center op-0" placeholder='اختر صورة الملف الشخصي' readonly/>
                                    <input type="file" class="op-0" name="profile-cover" accept="image/png, image/jpg">
                                    @if ($errors->has('profile-cover'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('profile-cover') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="profile-logo">الصورة الشخصية</label>
                                    <input type="text" id="profile-logo" class="form-control {{ $errors->has('profile-logo') ? ' is-invalid' : '' }} custom-input text-center op-0" placeholder='اختر صورة الملف الشخصي' readonly/>
                                    <input type="file" class="op-0" name="profile-logo" accept="image/png, image/jpg">
                                    @if ($errors->has('profile-logo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('profile-logo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="required-field" for="about">وصف المركز</label>
                                    <textarea id="about" class="form-control {{ $errors->has('about') ? ' is-invalid' : '' }} text-center required no-resize p-40"
                                              name="about"
                                              minlength="10" placeholder="وصف المركز" rows="10" maxlength="150"
                                              required>{{ $user->center->about }}</textarea>
                                    @if ($errors->has('about'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('about') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block custom-btn">حفظ</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-file')
    <script src="{{ asset('js/center/edit-center.js') }}"></script>
    <script src="{{ asset('js/center/plugins/select2/select2.full.min.js') }}"></script>
@endsection