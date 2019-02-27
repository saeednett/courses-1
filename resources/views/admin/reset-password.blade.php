@extends('admin.layouts.master')

@section('main-title', " تعديل كلمة المرور")

@section('page-links')
    <li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-users"></i>المسؤولين</a></li>
    <li class="active"><a href="{{ route('center.trainer.create') }}"><i class="fa fa-user-plus"></i>إضافة مسؤول</a>
    </li>
@endsection

@section('style-file')

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

        .invalid-feedback {
            color: #ab1717;
            width: 100%;
            display: block;
            direction: rtl;
            text-align: center;
        }

        .is-invalid {
            border-color: #ab1717;
        }

        .block {
            color: black;
            background: #FFF;
            border: 1px solid #ccc;
            font-weight: 400;
            padding: 20px;
            border-radius: 3px;
            box-shadow: 2px 1px 5px rgba(0, 0, 0, 0.25);
        }

        .block ol li {
            font-size: 15px;
        }

    </style>

    @if($errors->any())
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right rtl" style="margin-bottom: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="text-right rtl" style="margin-bottom: 0;">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="block animated fadeInUp">
                <h4>لحفظ بياناتك ننصحك باختيار رقم سري صعب التوقع ونقترح عليك مايلي...</h4>
                <ol>
                    <li>على الأقل مكون من 8 خانات وكلما زاد العدد كلما كان أصعب</li>
                    <li>يحتوي على حروف كبيرة وصغيرة باللغة الإنجليزية</li>
                    <li>يحتوي على أرقام ورموز لايمكن توقعها</li>
                    <li>لايعتمد على معلومة من معلوماتك الشخصية</li>
                    <li>لايعتمد على كلمة في القاموس لسهولة توقعها</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">

                <div class="panel-heading clearfix">
                    <h3 class="panel-title">إعادة تعيين كلمة المرور</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                        <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                    </ul>
                </div>

                <div class="panel-body">

                    <form method="post" action="{{ route('admin.reset.password.confirm') }}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}


                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field" for="old_password">كلمة المرور القديمة</label>
                                    <input type="password"
                                           class="form-control {{ $errors->has('old_password') ? ' is-invalid' : '' }} custom-input text-center"
                                           name="old_password" id="old_password" placeholder="كلمة المرور القديمة"
                                           minlength="8"
                                           maxlength="32" autocomplete="off" required>
                                    @if ($errors->has('old_password'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field" for="password">كلمة المرور</label>
                                    <input type="password"
                                           class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} custom-input text-center"
                                           name="password" id="password" placeholder="كلمة المرور الجديدة" minlength="8"
                                           maxlength="32" autocomplete="off" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field" for="password_confirmation">تأكيد كلمة المرور</label>
                                    <input type="password"
                                           class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }} custom-input text-center"
                                           name="password_confirmation" id="password_confirmation"
                                           placeholder="تأكيد كلمة المرور الجديدة" minlength="8" maxlength="32"
                                           autocomplete="off" required>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row" style="margin-top: 20px;">
                            <div class="col-lg-6 col-lg-offset-3">
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

                if ($(this).val().length == 0) {
                    if (charCode == 43) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    return true;
                }

            });

            $(".select2").select2();
            $(".select2-placeholer").select2({});

            $("#profile-image").on('click', function () {
                $("input[name=profile-image]").trigger('click');
            });

            $("input[name=profile-image]").on('change', function () {
                let file = $("input[name=profile-image]")[0].files[0];
                $("#profile-image").val(file.name);
            });
        });
    </script>

    <script src="{{ asset('js/center/plugins/select2/select2.full.min.js') }}"></script>
@endsection