@extends('center.layouts.master-v-1-1')

@section('main-title', "تعديل معلومات مسؤول دورات")

@section('page-links')
    <li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-users"></i>المسؤولين</a></li>
    <li class="active"><a href="{{ route('center.trainer.edit', $admin->id) }}"><i class="fa fa-user-plus"></i>عرض مسؤول</a></li>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/plugins/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/center/edit-admin.css') }}">
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

                    <form method="post" action="{{ route('center.admin.update', $admin->id) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="required-field rtl" for="name">اسم المسؤول</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }} custom-input text-center ltr"
                                           name="name" id="name" value="{{ $admin->name }}" placeholder="اسم المسؤول"
                                           minlength="6" maxlength="50" autocomplete="off" required>
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
                                           name="phone" id="phone" value="{{ $admin->user->phone }}" placeholder="رقم هاتف المسؤول" minlength="9" maxlength="13" autocomplete="off" required>
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="required-field" for="email">البريد الإلكتروني</label>
                                    <input type="email"
                                           class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }} custom-input text-center ltr"
                                           name="email" id="email" value="{{ $admin->user->email }}" placeholder="البريد الإلكتروني للمسؤول" autocomplete="off" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="required-field" for="username">اسم المستخدم</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }} custom-input text-center ltr"
                                           name="username" id="username" value="{{ $admin->user->username }}" placeholder="اسم المستخدم للمسؤول" minlength="5" maxlength="20" autocomplete="off" required>
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
                                    <label for="personal-profile">الصورة الشخصية</label>
                                    <input type="text" class="form-control custom-input text-center" placeholder='اختر صورة الملف الشخصي' id="profile-image" readonly/>
                                    <input type="file" class="op-0" name="profile-image" accept="image/png, image/jpg">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="status">الحالة</label>
                                    <select class="form-control select2-placeholer {{ $errors->has('status') ? ' is-invalid' : '' }}"
                                            id="status"
                                            name="status">
                                        @if($admin->user->status == 1)
                                            <option value="1" selected>فعال</option>
                                            <option value="0">غير فعال</option>
                                        @else
                                            <option value="1">فعال</option>
                                            <option value="0" selected>غير فعال</option>
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3 col-md-12 col-sm-12 col-xs-12">
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
    <script src="{{ asset('js/center/edit-admin.js') }}"></script>
    <script src="{{ asset('js/center/plugins/select2/select2.full.min.js') }}"></script>
@endsection