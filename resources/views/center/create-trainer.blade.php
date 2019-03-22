@extends('center.master-v-1-1')

@section('title', "إضافة مدرب جديد")
@section('main-title', "إضافة مدرب جديد")

@section('page-links')
    <li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-users"></i>المدربين</a></li>
    <li class="active"><a href="{{ route('center.trainer.create') }}"><i class="fa fa-user-plus"></i>إضافة مدرب</a></li>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/plugins/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/center/create-trainer.css') }}">
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
                    <h3 class="panel-title">إضافة مدرب جديد</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                        <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                    </ul>
                </div>

                <div class="panel-body">

                    <form method="post" action="{{ route('center.trainer.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="required-field rtl" for="name">اسم المدرب</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }} custom-input text-center ltr"
                                           name="name" id="name" value="{{ old('name') }}" placeholder="اسم المدرب"
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
                                    <label class="required-field rtl" for="phone">رقم الهاتف</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }} custom-input num-only text-center ltr"
                                           name="phone" id="phone" value="{{ old('phone') }}"
                                           placeholder="رقم هاتف المدرب" minlength="9" maxlength="13" autocomplete="off"
                                           required>
                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @else
                                        <small class="text-muted text-center center-block">الرجاء الإبتداء برمز الدولة..
                                            966+
                                        </small>
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
                                           name="email" id="email" value="{{ old('email') }}"
                                           placeholder="البريد الإلكتروني للمدرب" autocomplete="off" required>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="required-field" for="username">اسم المستخدم</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }} custom-input text-center ltr"
                                           name="username" id="username" value="{{ old('username') }}"
                                           placeholder="اسم المستخدم للمدرب" minlength="5" maxlength="20"
                                           autocomplete="off" required>
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
                                    <label class="required-field" for="nationality">الجنسية</label>
                                    <select class="form-control select2-placeholer {{ $errors->has('nationality') ? ' is-invalid' : '' }}"
                                            name="nationality">
                                        @foreach($nationalities as $nationality)
                                            @if(old('nationality') == $nationality->id)
                                                <option value="{{ $nationality->id }}"
                                                        selected>{{ $nationality->name }}</option>
                                            @else
                                                <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('nationality'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nationality') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="required-field" for="country">اللقب</label>
                                    <select class="form-control select2-placeholer {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                            name="title">
                                        @foreach($titles as $title)
                                            @if(old('title') == $title->id)
                                                <option value="{{ $title->id }}" selected>{{ $title->name }}</option>
                                            @else
                                                <option value="{{ $title->id }}">{{ $title->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="required-field" for="password_confirmation">تأكيد كلمة المرور</label>
                                    <input type="password"
                                           class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} custom-input text-center"
                                           name="password_confirmation" id="password_confirmation"
                                           placeholder="تأكيد كلمة المرور" minlength="8" maxlength="32"
                                           autocomplete="off" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label class="required-field" for="website">كلمة المرور</label>
                                    <input type="password"
                                           class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} custom-input text-center"
                                           name="password" id="password" placeholder="كلمة المرور" minlength="8"
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
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="status">الحالة</label>
                                    <select class="form-control select2-placeholer {{ $errors->has('status') ? ' is-invalid' : '' }}"
                                            id="status"
                                            name="status">
                                        @if(old('status') == 1)
                                            <option value="1" selected>فعال</option>
                                            <option value="0">غير فعال</option>
                                        @elseif(old('status') == 0)
                                            <option value="1">فعال</option>
                                            <option value="0" selected>غير فعال</option>
                                        @else
                                            <option value="1">فعال</option>
                                            <option value="0">غير فعال</option>
                                        @endif
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="personal-profile">الصورة الشخصية</label>
                                    <input type="text" id="profile-image"
                                           class="form-control {{ $errors->has('profile-image') ? ' is-invalid' : '' }} custom-input text-center"
                                           placeholder='اختر صورة الملف الشخصي' readonly required/>
                                    <input class="op-0" type="file" name="profile-image" accept="image/png, image/jpg" required>
                                    @if ($errors->has('profile-image'))
                                        <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $errors->first('profile-image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3 col-mg-12 col-sm-12 colxs-12">
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
    <script src="{{ asset('js/center/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/center/create-trainer.js') }}"></script>
@endsection