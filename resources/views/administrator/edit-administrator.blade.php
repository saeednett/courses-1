@extends('administrator.layouts.master-statistics')


@section('title', " تعديل المعلومات الشخصية")
@section('main-title', "تعديل المعلومات الشخصية")

@section('page-links')
    <li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-user"></i>الملف الشخصي</a></li>
    <li class="active"><a href="{{ route('administrator.edit') }}"><i class="fa fa-edit"></i>بياناتي الشخصية</a></li>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/edit-administrator.css') }}"/>
@endsection

@section('content')
    <div class="row">
        @if($errors->any())
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
                        <li>{{ $errors->first() }}</li>
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

                    <form method="post" action="{{ route('administrator.update') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">


                        <div class="row">
                            <div class="col-lg-8 col-lg-offset-2 text-center p-10">
                                @if($administrator->administrator->image == "default.jpg")
                                    <img class="img-thumbnail w-80 h-300-px" id="personal-image" src="{{ asset('img/main/default.jpg') }}"/>
                                @else
                                    <img class="img-thumbnail w-80 h-300-px" id="personal-image" src="/storage/administrator-images/{{ $administrator->administrator->image }}"/>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label for="profile-image">الصورة الشخصية</label>
                                    <input type="text" id="profile-image" class="form-control {{ $errors->has('profile-image') ? 'is-invalid' : '' }} custom-input text-center" placeholder='اختر صورة الملف الشخصي' readonly/>
                                    <input type="file" class="op-0" name="profile-image" accept="image/png, image/jpg" onchange="readURL(this);">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-30">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="required-field rtl" for="name">اسم المدير</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }} custom-input text-center ltr"
                                           name="name" id="name" value="{{ $administrator->administrator->name }}" placeholder="اسم المدير"
                                           minlength="6" maxlength="50" autocomplete="off" required>
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="required-field" for="username">اسم المستخدم</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }} custom-input text-center ltr"
                                           name="username" id="username" value="{{ $administrator->username }}" placeholder="اسم المستخدم للمدير" minlength="5" maxlength="20" autocomplete="off" required>
                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="required-field" for="email">البريد الإلكتروني</label>
                                    <input type="email"
                                           class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }} custom-input text-center ltr"
                                           name="email" id="email" value="{{ $administrator->email }}" placeholder="البريد الإلكتروني للمدير" autocomplete="off" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="required-field rtl" for="phone">رقم الهاتف</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }} custom-input num-only text-center ltr"
                                           name="phone" id="phone" value="{{ $administrator->phone }}" placeholder="رقم هاتف المسؤول" minlength="9" maxlength="13" autocomplete="off" required>
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
    <script src="{{ asset('js/administrator/edit-administrator.js') }}"></script>
@endsection