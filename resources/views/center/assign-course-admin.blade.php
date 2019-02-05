@extends('center.master-v-1-1')

@section('main-title', "تعيين مسؤولين الدورات")

@section('page-links')
    <li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-users"></i>المسؤولين</a></li>
    <li class="active"><a href="{{ route('center.course.admin.assign') }}"><i class="fa fa-user-plus"></i>تعيين مسؤولين
            الدورات</a></li>
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

        .select2-selection__arrow {
            height: 100% !important;
        }

        .select2-selection__rendered {
            margin-top: 11px !important;
            width: 100%;
            height: 100%;
            text-align: center;
        }

        .invalid-feedback {
            color: #ab1717;
            width: 100%;
            display: block;
            direction: rtl;
            text-align: center;
        }

        .is-invalid {
            border-color: #ab1717 !important;
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

                    <form method="post" action="{{ route('center.course.admin.store') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field" for="country">الدورة</label>
                                    <select class="form-control select2-placeholer {{ $errors->has('course') ? 'is-invalid' : '' }} is-invalid"
                                            name="course">
                                        @foreach($courses as $course)
                                            @if(old('course') == $course->id)
                                                <option value="{{ $course->id }}" selected>{{ $course->title }}</option>
                                            @else
                                                <option value="{{ $course->id }}">{{ $course->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('course'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('course') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field" for="country">المسؤول</label>
                                    <select class="form-control select2-placeholer {{ $errors->has('admin') ? 'is-invalid' : '' }}"
                                            name="admin">
                                        @foreach($admins as $admin)
                                            @if(old('admin') == $admin->id)
                                                <option value="{{ $admin->user->id }}"
                                                        selected>{{ $admin->user->name }}</option>
                                            @else
                                                <option value="{{ $admin->user->id }}">{{ $admin->user->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('admin'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('admin') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field" for="country">الصلاحية</label>
                                    <select class="form-control select2-placeholer {{ $errors->has('role') ? 'is-invalid' : '' }}"
                                            name="role">
                                        @if(old('role') == 1)
                                            <option value="1" selected>مسؤول الدورة</option>
                                            <option value="2">محضر الدورة</option>
                                        @elseif(old('role') == 2)
                                            <option value="1">مسؤول الدورة</option>
                                            <option value="2" selected>محضر الدورة</option>
                                        @else
                                            <option value="1">مسؤول الدورة</option>
                                            <option value="2">محضر الدورة</option>
                                        @endif
                                    </select>
                                    @if ($errors->has('role'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 15px;">
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

            $(".select2").select2();
            $(".select2-placeholer").select2({});
        });
    </script>

    <script src="{{ asset('js/center/plugins/select2/select2.full.min.js') }}"></script>
@endsection