@extends('center.master-v-1-1')

@section('main-title', "تعديل المعلومات الشخصية")

@section('page-links')
    <li><a href="index.html"><i class="fa fa-user"></i>الملف الشخص</a></li>
    <li class="active"><a href="form-basic.html">بياناتي الشخصية</a></li>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/plugins/select2/select2.css') }}">
@endsection

@section('content')
    <style>
        .required-field:after {
            color: #ff6771;
            content: " *";
            text-align: right;
        }

        .rtl {
            direction: rtl;
        }

        .ltr {
            direction: ltr;
        }

        select {
            direction: rtl;
            text-align: center !important;
            text-align-last: center !important;
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

        .select2-container--default .select2-selection--single {
            height: 50px !important;
            border-radius: 30px !important;
        }

        .select2-selection__arrow{
            height: 100% !important;
        }
        .select2-selection__rendered{
            margin-top: 6px;
            width: 100%;
            height: 100%;
            text-align: center;
        }
        .invalid-feedback{
            color: #ab1717;
            width: 100%;
            display: block;
            text-align: center;
        }
    </style>
    <div class="row">
        @if($errors->any())
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right rtl" style="margin-bottom: 0;">
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
                    <ul class="text-right rtl" style="margin-bottom: 0;">
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

                    <form method="post" action="{{ route('center.update') }}">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="required-field rtl" for="name">اسم المركز</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }} custom-input text-center ltr"
                                           name="name" id="name" value="{{ $center->name }}"
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
                                           name="phone" id="phone" value="{{ $center->phone }}" maxlength="13" minlength="9">
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
                                           name="email" id="email" value="{{ $center->email }}">
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
                                           name="username" id="username" value="{{ $center->username }}">
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
                                           value="{{ $center->center->verification_code }}" maxlength="10">
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
                                           value="{{ $center->center->verification_authority }}">
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
                                            name="country">
                                        @foreach($countries as $country)
                                            @if($center->center->city->country->id == $country->id)
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
                                    <label for="country">المدينة</label>
                                    <select class="form-control select2-placeholer {{ $errors->has('city') ? ' is-invalid' : '' }}"
                                            name="city">
                                        @foreach($cities as $city)
                                            @if($center->center->city_id == $city->id)
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="bank">البنك</label>
                                    <select class="form-control select2-placeholer {{ $errors->has('bank') ? ' is-invalid' : '' }}"
                                            name="bank" id="bank">
                                        @foreach($banks as $bank)
                                            @if($center->center->bank_id == $bank->id)
                                                <option value="{{ $bank->id }}" selected>{{ $bank->name }}</option>
                                            @else
                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('bank'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('bank') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="required-field mr-4" for="account_number">رقم الحساب</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('account_number') ? ' is-invalid' : '' }} custom-input text-center ltr"
                                           name="account_number" id="account_number" value="{{ $center->center->account_number }}"
                                           placeholder="رقم الحساب | الأيبان">
                                    @if ($errors->has('account_number'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="required-field" for="website">الموقع الاإلكتروني</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('website') ? ' is-invalid' : '' }} custom-input text-center"
                                           name="website" id="website"
                                           value="{{ $center->center->website }}">
                                    @if ($errors->has('website'))
                                        <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('website') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="" for="website">كلمة المرور</label>
                                    <input type="password"
                                           class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} custom-input text-center"
                                           name="password" id="password" placeholder="كلمة المرور">
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="personal-profile">الصورة الشخصية</label>
                                    <input type="text" class="form-control custom-input text-center" placeholder='اختر صورة الملف الشخصي' />
                                    <input type="file" name="personal-profile" style="opacity: 0;" accept="image/png, image/jpg">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="personal-profile">الصورة الشخصية</label>
                                    <input type="text" class="form-control custom-input text-center" placeholder='اختر صورة الملف الشخصي' />
                                    <input type="file" name="personal-profile" style="opacity: 0;" accept="image/png, image/jpg">
                                </div>
                            </div>


                        </div>

                        {{--<div class="checkbox">--}}
                        {{--<label><input type="checkbox">Check me out</label>--}}
                        {{--</div>--}}
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
                        $('select[name=city]').val(null).trigger('change');
                        for (let i = 0; i < data['data'].length; i++) {
                            $('select[name=city]').append("<option value='" + data['data'][i]['id'] + "'>" + data['data'][i]['name'] + "</option>");
                        }

                        $('select[name=city]').val(data['data'][0]['id']); // Select the option with a value of '1'
                        $('select[name=city]').trigger('change');
                    },
                    error: function () {
                        alert("هناك خطأ الرجاء المحاولة لاحقا");
                    }
                });
            });

            $(".select2").select2();
            $(".select2-placeholer").select2({

            });
        });
    </script>

    <script src="{{ asset('js/center/plugins/select2/select2.full.min.js') }}"></script>
@endsection