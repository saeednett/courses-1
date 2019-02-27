@extends('admin.layouts.master')

@section('main-title', " تعديل كلمة المرور")

@section('page-links')
    <li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-users"></i>المسؤولين</a></li>
    <li class="active"><a href="{{ route('center.trainer.create') }}"><i class="fa fa-user-plus"></i>إضافة مسؤول</a></li>
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
            direction: rtl;
            text-align: center;
        }
        .is-invalid{
            border-color: #ab1717;
        }
    </style>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#personal-image')
                        .attr('src', e.target.result)
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <div class="row">
        @if($errors->any())
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right rtl" style="margin-bottom: 0;">
                        <li>{{ $errors->first() }}</li>
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

                    <form method="post" action="{{ route('admin.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">


                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3 text-center" style="padding: 10px;">
                                <img class="img-thumbnail" id="personal-image" src="/storage/admin-images/{{ \Illuminate\Support\Facades\Auth::user()->admin->image }}" style="width: 80%; height: 80%;"/>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 30px;">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field rtl" for="name">اسم المسؤول</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }} custom-input text-center ltr"
                                           name="name" id="name" value="{{ $admin->name }}" placeholder="اسم المسؤول"
                                           minlength="6" maxlength="50" autocomplete="off" required>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field rtl" for="phone">رقم الهاتف</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }} custom-input num-only text-center ltr"
                                           name="phone" id="phone" value="{{ $admin->phone }}" placeholder="رقم هاتف المسؤول" minlength="9" maxlength="13" autocomplete="off" required>
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @else
                                        <small class="text-muted text-center center-block">الرجاء الإبتداء برمز الدولة.. 966+</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field" for="email">البريد الإلكتروني</label>
                                    <input type="email"
                                           class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }} custom-input text-center ltr"
                                           name="email" id="email" value="{{ $admin->email }}" placeholder="البريد الإلكتروني للمسؤول" autocomplete="off" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field" for="username">اسم المستخدم</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }} custom-input text-center ltr"
                                           name="username" id="username" value="{{ $admin->username }}" placeholder="اسم المستخدم للمسؤول" minlength="5" maxlength="20" autocomplete="off" required>
                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label for="profile-image">الصورة الشخصية</label>
                                    <input type="text" id="profile-image" class="form-control {{ $errors->has('profile-image') ? 'is-invalid' : '' }} custom-input text-center" placeholder='اختر صورة الملف الشخصي' readonly/>
                                    <input type="file" name="profile-image" style="opacity: 0;" accept="image/png, image/jpg" onchange="readURL(this);">
                                </div>
                            </div>
                        </div>

                        <div class="row">
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

                if ( $(this).val().length == 0 ){
                    if ( charCode == 43 ){
                        return true;
                    }else {
                        return false;
                    }
                }else{
                    if ( charCode > 31 && (charCode < 48 || charCode > 57)) {
                        return false;
                    }
                    return true;
                }

            });

            $("#profile-image").on('click', function () {
                $("input[name=profile-image]").trigger('click');
            });

            $("input[name=profile-image]").on('change', function (e) {
                let file = $("input[name=profile-image]")[0].files[0];
                $("#profile-image").val(file.name);
            });



        });
    </script>

    <script src="{{ asset('js/center/plugins/select2/select2.full.min.js') }}"></script>
@endsection