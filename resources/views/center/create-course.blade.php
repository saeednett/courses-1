@extends('center.master-v-1-1')

@section('main-title', "إضافة دورة جديدة")

@section('page-links')
    <li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-users"></i>الدورات</a></li>
    <li class="active"><a href="{{ route('center.course.create', Auth::user()->id) }}"><i
                    class="fa fa-pencil-square"></i>إضافة دورة</a></li>
@endsection


@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/plugins/select2/select2.css') }}">
    <link href="{{ asset('css/center/plugins/datepicker/bootstrap-datepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/center/bootstrap-clockpicker.min.css') }}" rel="stylesheet">
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
            width: 100%;
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
            width: 100% !important;
            height: 100% !important;
            text-align: center !important;
        }

        .invalid-feedback {
            color: #ab1717;
            width: 100% !important;
            display: block !important;
            direction: rtl !important;
            text-align: center !important;
        }

        .is-invalid {
            border-color: #ab1717 !important;
        }

        .popover-title {
            direction: ltr !important;
        }
    </style>

    <div class="row">
        <div class="modal fade" id="warning-model" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><h2 class="text-danger">تنبيه!</h2></h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">لقد قمت بإضافة الحد الأقصى من المدربين. قم بإضافة المزيد لكي تتمكن من تعينهم للدورات</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        @if($errors->any())
            <div class="col-lg-12 animatedParent animateOnce z-index-49">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right rtl" style="margin-bottom: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session()->has('success'))
            <div class="col-lg-12 animatedParent animateOnce z-index-49">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="text-right rtl" style="margin-bottom: 0;">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        @endif

        <div class="col-lg-12 animatedParent animateOnce z-index-49">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">إضافة دورة تدربية جديدة</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                        <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <form id="rootwizard-2" class="form-wizard validate-form-wizard validate" method="post"
                          action="{{ route('center.course.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="wizard-navbar">
                            <ul>
                                <li class="active "><a href="#tab2-1" data-toggle="tab"><span class="wz-number">1</span>
                                        <span class="wz-label">المعلومات الأولية</span></a></li>
                                <li><a href="#tab2-2" data-toggle="tab"><span class="wz-number">2</span> <span
                                                class="wz-label">معلومات المدربين</span></a></li>
                                <li><a href="#tab2-3" data-toggle="tab"><span class="wz-number">3</span> <span
                                                class="wz-label">المعلومات المالية</span></a></li>
                                <li><a href="#tab2-4" data-toggle="tab"><span class="wz-number">4</span> <span
                                                class="wz-label">معلومات المواعيد</span></a></li>
                            </ul>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab2-1">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="required-field" for="title">عنوان الدورة</label>
                                            <input type="text"
                                                   class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }} custom-input text-center ltr"
                                                   name="title" id="title" value="{{ old('title') }}"
                                                   placeholder="عنوان الدورة" minlength="10"
                                                   autocomplete="off" required>
                                            @if ($errors->has('title'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="required-field" for="category">تصنيف الدورة</label>
                                            <select class="form-control select2-placeholer {{ $errors->has('category') ? 'is-invalid' : '' }}"
                                                    name="category" required>
                                                @foreach($categories as $category)
                                                    @if(old('category') == $category->id)
                                                        <option value="{{ $category->id }}"
                                                                selected>{{ $category->name }}</option>
                                                    @else
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('category'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('category') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="required-field" for="visible">ظهور الدورة</label>
                                            <select id="visible"
                                                    class="form-control select2-placeholer {{ $errors->has('visible') ? 'is-invalid' : '' }}"
                                                    name="visible" required>
                                                @if(old('visible') == 1)
                                                    <option value="1" selected>عامة</option>
                                                    <option value="2">خاصة</option>
                                                @elseif(old('visible') == 2)
                                                    <option value="1">عامة</option>
                                                    <option value="2" selected>خاصة</option>
                                                @else
                                                    <option value="1">عامة</option>
                                                    <option value="2">خاصة</option>
                                                @endif
                                            </select>
                                            @if ($errors->has('visible'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('visible') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="required-field" for="template">قالب الشهادة</label>
                                            <select class="form-control select2-placeholer {{ $errors->has('template') ? 'is-invalid' : '' }} custom-input"
                                                    name="template" required>
                                                @if(old('template') == 1)
                                                    <option value="1" selected>القالب الأول</option>
                                                    <option value="2">القالب الثاني</option>
                                                    <option value="3">القالب الثالث</option>
                                                @elseif(old('template') == 2)
                                                    <option value="1">القالب الأول</option>
                                                    <option value="2" selected>القالب الثاني</option>
                                                    <option value="3">القالب الثالث</option>
                                                @elseif(old('template') == 3)
                                                    <option value="1">القالب الأول</option>
                                                    <option value="2">القالب الثاني</option>
                                                    <option value="3" selected>القالب الثالث</option>
                                                @else
                                                    <option value="1">القالب الأول</option>
                                                    <option value="2">القالب الثاني</option>
                                                    <option value="3">القالب الثالث</option>
                                                @endif
                                            </select>
                                            @if ($errors->has('template'))
                                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('template') }}</strong>
                                        </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="required-field" for="country">الدولة</label>
                                            <select class="form-control select2-placeholer {{ $errors->has('country') ? 'is-invalid' : '' }}"
                                                    name="country" required>
                                                @foreach($countries as $country)
                                                    @if(old('country') == $country->id)
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

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="required-field" for="city">المدينة</label>
                                            <select class="form-control select2-placeholer {{ $errors->has('city') ? 'is-invalid' : '' }}"
                                                    name="city" required>
                                                @foreach($cities as $city)
                                                    @if(old('city') == $city->id)
                                                        <option value="{{ $city->id }}"
                                                                selected>{{ $city->name }}</option>
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
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="required-field" for="address">وصف عنوان إقامة الدورة</label>
                                            <input type="text"
                                                   class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }} custom-input text-center ltr"
                                                   name="address" id="address" value="{{ old('address') }}"
                                                   placeholder="وصف عنوان إقامة الدورة" minlength="10"
                                                   autocomplete="off" required>
                                            @if ($errors->has('address'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('address') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="required-field" for="location">عنوان إقامة الدورة في
                                                الخرائط</label>
                                            <input type="text"
                                                   class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }} custom-input text-center ltr"
                                                   name="location" id="location" value="{{ old('location') }}"
                                                   placeholder="عنوان إقامة الدورة في الخرائط" minlength="10"
                                                   autocomplete="off" required>
                                            @if ($errors->has('location'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('location') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="required-field" for="personal-profile">غلاف الدورة</label>
                                            <input type="text" id="course-poster-1"
                                                   class="form-control custom-input text-center"
                                                   placeholder='اختر غلاف الدورة' readonly required/>
                                            <input type="file" name="course-poster-1" style="opacity: 0;"
                                                   accept="image/png, image/jpg" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="required-field" for="personal-profile">غلاف الدورة -
                                                02 </label>
                                            <input type="text" id="course-poster-2"
                                                   class="form-control custom-input text-center"
                                                   placeholder='اختر غلاف الدورة - 02' readonly required/>
                                            <input type="file" name="course-poster-2" style="opacity: 0;"
                                                   accept="image/png, image/jpg" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="required-field" for="description">وصف الدورة</label>
                                            <textarea id="description" class="form-control text-center required"
                                                      name="description"
                                                      minlength="10" placeholder="وصف الدورة" rows="10"
                                                      style="resize: none;" required>{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane" id="tab2-2">
                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-2 col-md-6 col-md-offset-2 col-sm-10 col-xs-10">
                                        <div class="form-group">
                                            <label class="required-field" for="trainer">المدرب</label>
                                            <select class="form-control select2-placeholer {{ $errors->has('trainer') ? 'is-invalid' : '' }}"
                                                    name="trainer[]" id="not here" required>
                                                @foreach($trainers as $trainer)
                                                    <option value="{{ $trainer->id }}">{{ $trainer->user->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('trainer'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('trainer') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                        <label for="trainer"></label>
                                        <button type="button" class="btn btn-success btn-block custom-input"
                                                id="add-trainer"><i class="fa fa-plus-circle"></i></button>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane" id="tab2-3">
                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="form-group">
                                            <label class="required-field" for="type">نوع الدورة</label>
                                            <select class="form-control select2-placeholer {{ $errors->has('type') ? 'is-invalid' : '' }}"
                                                    name="type" required>
                                                @if(old('type') == 1)
                                                    <option value="1" selected>مجانية</option>
                                                    <option value="2">مدفوعة</option>
                                                @elseif(old('type') == 2)
                                                    <option value="1">مجانية</option>
                                                    <option value="2" selected>مدفوعة</option>
                                                @else
                                                    <option value="1">مجانية</option>
                                                    <option value="2">مدفوعة</option>
                                                @endif
                                            </select>
                                            @if ($errors->has('type'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('type') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab2-4">

                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="form-group">
                                            <label class="required-field" for="start_date">تاريخ بدء الدورة</label>
                                            <input type="text"
                                                   class="form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }} custom-input text-center ltr"
                                                   name="start_date" id="start_date" value="{{ old('start_date') }}"
                                                   placeholder="تاريخ بدء الدورة"
                                                   autocomplete="off" required>
                                            @if ($errors->has('start_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('start_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="form-group">
                                            <label class="required-field" for="start_time">وقت بدء الدورة</label>
                                            <input type="text"
                                                   class="form-control {{ $errors->has('start_time') ? 'is-invalid' : '' }} custom-input text-center"
                                                   name="start_time" id="start_time" value="{{ old('start_time') }}"
                                                   placeholder="وقت بدء الدورة"
                                                   autocomplete="off" required>
                                            @if ($errors->has('start_time'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('start_time') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="form-group">
                                            <label class="required-field" for="attendance">عدد المقاعد</label>
                                            <input type="text"
                                                   class="form-control {{ $errors->has('attendance') ? 'is-invalid' : '' }} custom-input text-center num-only ltr"
                                                   name="attendance" id="attendance"
                                                   value="{{ old('attendance') }}"
                                                   placeholder="عدد المقاعد"
                                                   autocomplete="off" maxlength="4" required>
                                            @if ($errors->has('attendance'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('attendance') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{--البرمجة بإستخدام لارافيل--}}
                                {{--الشوقية خلف حلويات زمان--}}
                                {{--سوف تتعلم في هذه الدورة اساسيات البرمجة بإستخدام لارافيل ومن ثم سوف ننتقل للتعمق قليلا ولنحول كل ما مررنا به الى تطبيق عملي--}}

                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="form-group">
                                            <label class="required-field" for="gender">الحضور</label>
                                            <select id="gender"
                                                    class="form-control select2-placeholer {{ $errors->has('gender') ? 'is-invalid' : '' }}"
                                                    name="gender" required>
                                                @if(old('gender') == 1)
                                                    <option value="1" selected>رجال</option>
                                                    <option value="2">نساء</option>
                                                    <option value="3">رجال ونساء</option>
                                                @elseif(old('gender') == 2)
                                                    <option value="1">رجال</option>
                                                    <option value="2" selected>نساء</option>
                                                    <option value="3">رجال ونساء</option>
                                                @elseif(old('gender') == 3)
                                                    <option value="1">رجال</option>
                                                    <option value="2">نساء</option>
                                                    <option value="3" selected>رجال ونساء</option>
                                                @else
                                                    <option value="1">رجال</option>
                                                    <option value="2">نساء</option>
                                                    <option value="3">رجال ونساء</option>
                                                @endif
                                            </select>
                                            @if ($errors->has('gender'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('gender') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="form-group">
                                            <label class="required-field" for="start_date">تاريخ انتهاء الدورة</label>
                                            <input type="text"
                                                   class="form-control {{ $errors->has('finish_date') ? 'is-invalid' : '' }} custom-input text-center ltr"
                                                   name="finish_date" id="finish_date" value="{{ old('finish_date') }}"
                                                   placeholder="تاريخ انتهاء الدورة"
                                                   autocomplete="off" readonly disabled required>
                                            @if ($errors->has('finish_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('finish_date') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <div class="form-group">
                                            <label class="required-field" for="end_reservation">تاريخ انتهاء
                                                التسجيل</label>
                                            <input type="text"
                                                   class="form-control {{ $errors->has('end_reservation') ? 'is-invalid' : '' }} custom-input text-center ltr"
                                                   name="end_reservation" id="start_date"
                                                   value="{{ old('end_reservation') }}"
                                                   placeholder="تاريخ انتهاء التسجيل"
                                                   autocomplete="off" readonly disabled required>
                                            @if ($errors->has('end_reservation'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('end_reservation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-lg-4 col-lg-offset-4">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block custom-btn" id="submit">حفظ
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <ul class="pager wizard">
                                <li class="previous"><a href="javascript:void(0)"><i class="icon-right-open"></i>السابق</a>
                                </li>
                                <li class="next"><a href="javascript:void(0)">التالي<i class="icon-left-open"></i></a>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script-file')
    <!--Ajax Validattion-->
    <script src="{{ asset('js/center/jquery.validate.min.js') }}"></script>
    <!--Bootstrap Wizard-->
    <script src="{{ asset('js/center/bootstrap-clockpicker.min.js') }}"></script>
    <script src="{{ asset('js/center/plugins/wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('js/center/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/center/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script>
        $(document).ready(function () {

            function refreshSelect() {
                // $(".select2").select2();
                $(".select2-placeholer").select2({});
            }

            // Form Wizard
            if ($.isFunction($.fn.bootstrapWizard)) {

                $('#rootwizard').bootstrapWizard({
                    tabClass: 'wizard-steps',
                    onTabShow: function ($tab, $navigation, index) {
                        $tab.prevAll().addClass('completed');
                        $tab.nextAll().removeClass('completed');
                        $tab.removeClass('completed');
                    }

                });

                $(".validate-form-wizard").each(function (i, formwizard) {
                    var $this = $(formwizard);
                    var $progress = $this.find(".steps-progress div");

                    var $validator = $this.validate({
                        rules: {
                            name: {
                                required: true,
                                minlength: 10,
                            },

                            category: {
                                required: true,
                                minlength: 1,
                                maxlength: 99,
                            },

                            template: {
                                required: true,
                                minlength: 1,
                                maxlength: 3,
                            },

                            type: {
                                required: true,
                                minlength: 1,
                                maxlength: 2,
                            },

                            city: {
                                required: true,
                                minlength: 1,
                                maxlength: 99,
                            },

                            country: {
                                required: true,
                                minlength: 1,
                                maxlength: 99,
                            },

                            address: {
                                required: true,
                                minlength: 10,
                                maxlength: 200,
                            },

                            location: {
                                required: true,
                                minlength: 10,
                                maxlength: 50,
                            },

                            password: {
                                required: true,
                                minlength: 3
                            },
                            confirmpassword: {
                                required: true,
                                minlength: 3
                            },
                            email: {
                                required: true,
                                email: true,
                                minlength: 3,
                            }
                        }
                    });

                    // Validation
                    var checkValidaion = function (tab, navigation, index) {
                        if ($this.hasClass('validate')) {
                            var $valid = $this.valid();
                            if (!$valid) {
                                $validator.focusInvalid();
                                return false;
                            }
                        }

                        return true;
                    };

                    $this.bootstrapWizard({
                        tabClass: 'wizard-steps',
                        onNext: checkValidaion,
                        onTabClick: checkValidaion,
                        onTabShow: function ($tab, $navigation, index) {
                            $tab.removeClass('completed');
                            $tab.prevAll().addClass('completed');
                            $tab.nextAll().removeClass('completed');
                            refreshSelect();
                        }
                    });
                });
            }

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

            refreshSelect();


            $("#add-trainer").on('click', function () {
                let select = $("select[name='trainer[]']");
                let options = $("select[name='trainer[]']:first").children();

                if (parseInt(select.length) >= parseInt(options.length)) {
                    $("#warning-model").modal("show");
                } else {
                    $('#tab2-2').append("<div class='row'><div class='col-lg-6 col-lg-offset-2 col-md-6 col-md-offset-2 col-sm-10 col-xs-10'> <div class='form-group'><label class='required-field' for='trainer'>المدرب</label><select class='form-control select2-placeholer {{ $errors->has('trainer') ? 'is-invalid' : '' }} custom-input' name='trainer[]'></select></div></div> <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'> <label for='trainer'></label><button type='button' class='btn btn-danger btn-block custom-input remove'><i class='fa fa-trash'></i></button> </div> </div>");
                    for (let i = 0; i < options.length; i++) {
                        let select = $("select[name='trainer[]']:last");
                        select.append("<option value='" + options.eq(i).attr('value') + "' >" + options.eq(i).text() + "</option>");
                    }
                    refreshSelect();
                }
            });

            $(document).on('click', '.remove', function () {
                $(this).parent().parent().remove();
            });


            $("select[name=type]").on('change', function () {
                let value = $(this).val();
                if (value == 2) {
                    $("#tab2-3").append("<div class='row'> <div class='col-lg-6 col-lg-offset-3'> <div class='form-group'> <label class='required-field' for='price'>قيمة الدورة</label> <input type='text' class='form-control custom-input text-center num-only ltr' name='price' id='price'  placeholder='قيمة الدورة' autocomplete='off' required> </div></div> </div>   <div class='row'> <div class='col-lg-6 col-lg-offset-3'> <div class='form-group'> <label class='required-field' for='coupon'>كوبونات الخصم</label> <select class='form-control select2-placeholer {{ $errors->has('coupon') ? 'is-invalid' : '' }}' name='coupon' id='coupon'> <option value='0'> لا يوجد كوبونات خصم</option><option value='1'>يوجد كوبونات خصم</option></select></div></div> </div>");
                    refreshSelect();
                } else {
                    $("#tab2-3 > div:not(#tab2-3 > div:eq(0))").remove();
                }
            });

            $(document).on('change', 'select[name=coupon]', function () {
                let value = $(this).val();
                if (value == 1) {
                    $("#tab2-3").append("<div class='row'><div class='col-lg-2 col-lg-offset-5'> <label for='trainer'></label><button type='button' class='btn btn-success btn-block custom-input' id='add-coupon'><i class='fa fa-plus-circle'></i></button> </div> </div>");
                    $("#tab2-3").append("<div class='row' style='margin-top:20px;'><div class='col-lg-4 col-lg-offset-2'> <div class='form-group'> <label class='required-field' for='coupon'>كود الخصم</label> <input type='text' class='form-control custom-input text-center ltr' name='coupon_code[]'  placeholder='كود الخصم' autocomplete='off' required> </div></div> <div class='col-lg-4'> <div class='form-group'> <label class='required-field' for='coupon'>قيمة الخصم</label> <input type='text' class='form-control custom-input text-center num-only ltr' name='coupon_discount[]'  placeholder='قيمة الخصم بالنسبة المئوية' autocomplete='off' required> </div></div> </div>");
                } else {
                    $("#tab2-3 > div:not(#tab2-3 > div:eq(0), #tab2-3 > div:eq(1), div:eq(2))").remove();
                }
            });

            $(document).on('click', '#add-coupon', function () {
                $("#tab2-3").append("<div class='row' style='margin-top:20px;'><div class='col-lg-3 col-lg-offset-2'> <div class='form-group'> <label class='required-field' for='coupon'>كود الخصم</label> <input type='text' class='form-control custom-input text-center ltr' name='coupon_code[]'  placeholder='كود الخصم' autocomplete='off' required> </div></div> <div class='col-lg-3'> <div class='form-group'> <label class='required-field' for='coupon'>قيمة الخصم</label> <input type='text' class='form-control custom-input text-center num-only ltr' name='coupon_discount[]'  placeholder='قيمة الخصم بالنسبة المئوية' autocomplete='off' required> </div></div> <div class='col-lg-2'> <label for='trainer'></label><button type='button' class='btn btn-danger btn-block custom-input remove'><i class='fa fa-trash'></i></button> </div> </div>");
            });

            refreshTimePicker();

            function refreshTimePicker() {

                $.fn.datepicker.dates['ar'] = {
                    days: ["الاأحد", "الاإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"],
                    daysShort: ["احد", "اثن", "ثلا", "ارب", "خمي", "جمع", "سبت"],
                    daysMin: ["اح", "اث", "ثل", "ار", "خم", "جم", "سب"],
                    months: ["يناير", "فبراير", "مارس", "ابريل", "مايو", "يونيو", "يوليو", "اغصطس", "سبتمبر", "اكتوبر", "نوفمبر", "ديسمبر"],
                    monthsShort: ["ينا", "فبر", "مار", "ابر", "ماي", "يون", "يول", "اغسط", "سبت", "اكت", "نوف", "ديس"],
                    today: "اليوم",
                    clear: "حذف",
                    format: "yyyy/mm/dd",
                    titleFormat: "yyyy MM", /* Leverages same syntax as 'format' */
                    weekStart: 0,
                };

                $("input[name=start_date]").datepicker({
                    keyboardNavigation: false,
                    forceParse: false,
                    todayHighlight: true,
                    format: 'yyyy/mm/dd',
                    autoclose: true,
                    clearBtn: true,
                    startDate: new Date(),
                    title: "تاريخ الدورة",
                    language: "ar"

                });

                initializeFinishDate();
                function initializeFinishDate() {
                    $("input[name=finish_date]").datepicker({
                        keyboardNavigation: false,
                        forceParse: false,
                        todayHighlight: false,
                        format: 'yyyy/mm/dd',
                        autoclose: true,
                        clearBtn: true,
                        title: "تاريخ انتهاء الدورة",
                        language: "ar"

                    });
                }

                function refreshFinishDate(date){
                    if (date.length < 10 || date.length > 10){
                        $("input[name=finish_date]").prop({'readonly': false, 'disabled': true});
                    }else {
                        $("input[name=finish_date]").prop({'readonly': false, 'disabled': false});
                        $("input[name=finish_date]").datepicker('update', '');
                        $("input[name=finish_date]").datepicker( 'setStartDate', new Date(date));
                    }
                }


                initializeEndReservation();
                function initializeEndReservation() {
                    $("input[name=end_reservation]").datepicker({
                        keyboardNavigation: false,
                        forceParse: false,
                        todayHighlight: false,
                        format: 'yyyy/mm/dd',
                        autoclose: true,
                        clearBtn: true,
                        title: "تاريخ انتهاء التسجيل",
                        language: "ar"

                    });
                }

                function refreshEndReservation(date) {
                    if (date.length < 10 || date.length > 10) {
                        $("input[name=end_reservation]").prop({'readonly': false, 'disabled': true});
                    } else {
                        $("input[name=end_reservation]").prop({'readonly': false, 'disabled': false});
                        $("input[name=end_reservation]").datepicker('update', '');
                        $("input[name=end_reservation]").datepicker( 'setEndDate', new Date(date));
                        $("input[name=end_reservation]").datepicker( 'setStartDate', new Date());
                    }
                }


                $("input[name=start_date]").on('change', function () {
                    refreshFinishDate($("input[name=start_date]").val());
                    refreshEndReservation($("input[name=start_date]").val());

                });

                $("input[name=start_time]").clockpicker({
                    autoclose: true,
                    placement: "top",
                    align: "right",
                    donetext: "موافق",
                    // twelvehour: true,
                    default: 'now'
                });

            }

            $("#course-poster-1").on('click', function () {
                $("input[name=course-poster-1]").trigger('click');
            });

            $("input[name=course-poster-1]").on('change', function () {
                let file = $("input[name=course-poster-1]")[0].files[0];
                $("#course-poster-1").val(file.name);
            });

            $("#course-poster-2").on('click', function () {
                $("input[name=course-poster-2]").trigger('click');
            });

            $("input[name=course-poster-2]").on('change', function () {
                let file = $("input[name=course-poster-2]")[0].files[0];
                $("#course-poster-2").val(file.name);
            });


            $(document).on("keypress", '.num-only', function (evt) {
                let charCode = (evt.which) ? evt.which : event.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            });
        });
    </script>
@endsection