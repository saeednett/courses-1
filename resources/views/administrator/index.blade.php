@extends('administrator.layouts.master-statistics')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/index.css') }}">
@endsection

@section('content')
    <!-- Main content -->

    @if(session()->has('success'))
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="rtl mb-0 text-success text-right">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="rtl mb-0 text-danger text-right">
                        <li>{{ $errors->first() }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="modal fade" id="warning-model" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header text-right">
                        <h4 class="modal-title text-danger close" data-dismiss="modal" style="float: right;">تنبيه!</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p class="text-danger">سوف يتم إظهار الدورة التي تم التأكد منها في الصفحة الرئيسية</p>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success" id="agree-warning">موافق</button>
                        <button class="btn btn-danger" id="cancel-warning">إلغاء</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات الدورات العامة</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">اسم الدورة</th>
                                <th class="text-center">تاريخ الدورة</th>
                                <th class="text-center">المدينة</th>
                                <th class="text-center">عدد المقاعد</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center" colspan="2">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($public_courses) > 0)
                                @foreach($public_courses as $course)
                                    <tr class="gradeX">
                                        <td class="pt-18">
                                            {{ $course->title }}
                                            <input type="hidden" name="courses[]" value="{{ $course->identifier }}"
                                                   form="public-form">
                                            <input type="hidden" name="type" value="public" form="public-form">
                                        </td>
                                        <td class="ltr pt-18">{{ date( 'Y-M-D h:i' ,strtotime($course->created_at)) }}</td>
                                        <td class="pt-18">{{ $course->city->name }}</td>
                                        <td class="pt-18">{{ $course->attendance }}</td>
                                        @if($course->validation == 1)
                                            <td class="text-success pt-18">مؤكدة</td>
                                        @else
                                            <td class="text-danger pt-18">غير مؤكدة</td>
                                        @endif


                                        <td class="pt-18">
                                            <a href="{{ route('administrator.course.preview', $course->identifier) }}" target="_blank">عرض
                                                الدورة</a>
                                        </td>

                                        <td>
                                            @if ( $course->validation == 1 )
                                                <input type="checkbox" data-toggle="toggle"
                                                       data-on="تأكيد" data-off="غير مؤكدة" data-onstyle="success"
                                                       data-offstyle="danger" checked>
                                                <input type="hidden" name="validations[]" value="1"
                                                       form="public-form">
                                            @else
                                                <input type="checkbox" data-toggle="toggle"
                                                       data-on="تأكيد" data-off="غير مؤكدة" data-onstyle="success"
                                                       data-offstyle="danger">
                                                <input type="hidden" name="validations[]" value="0"
                                                       form="public-form">
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="6">
                                        <h3 class="mt-15">لاتوجد دورات عامة مسجلة في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    @if(count($public_courses) > 0)
                        <form method="post" action="{{ route('administrator.courses.confirmation') }}"
                              id="public-form">
                            {{ csrf_field() }}
                            <button class="btn btn-success col-lg-2" id="public-form-save-changes">
                                موافق
                            </button>
                        </form>
                    @endif


                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات الدورات الخاصة</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">اسم الدورة</th>
                                <th class="text-center">تاريخ الدورة</th>
                                <th class="text-center">المدينة</th>
                                <th class="text-center">عدد المقاعد</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center" colspan="2">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($private_courses) > 0)
                                @foreach($private_courses as $course)
                                    <tr class="gradeX">
                                        <td class="pt-18">
                                            {{ $course->title }}
                                            <input type="hidden" name="courses[]" value="{{ $course->identifier }}"
                                                   form="private-form">
                                            <input type="hidden" name="type" value="private" form="private-form">
                                        </td>
                                        <td class="ltr pt-18">{{ date( 'Y-M-D h:i' ,strtotime($course->created_at)) }}</td>
                                        <td class="pt-18">{{ $course->city->name }}</td>
                                        <td class="pt-18">{{ $course->attendance }}</td>
                                        @if($course->validation == 1)
                                            <td class="text-success pt-18">مؤكدة</td>
                                        @else
                                            <td class="text-danger pt-18">غير مؤكدة</td>
                                        @endif


                                        <td class="pt-18">
                                            <a href="{{ route('admin.courses.payment', $course->identifier) }}">عرض
                                                الدورة</a>
                                        </td>

                                        <td>
                                            @if ( $course->validation == 1 )
                                                <input type="checkbox" data-toggle="toggle"
                                                       data-on="تأكيد" data-off="غير مؤكدة" data-onstyle="success"
                                                       data-offstyle="danger" checked>
                                                <input type="hidden" name="validations[]" value="1"
                                                       form="private-form">
                                            @else
                                                <input type="checkbox" data-toggle="toggle"
                                                       data-on="تأكيد" data-off="غير مؤكدة" data-onstyle="success"
                                                       data-offstyle="danger">
                                                <input type="hidden" name="validations[]" value="0"
                                                       form="private-form">
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="6">
                                        <h3 class="mt-15">لاتوجد دورات خاصة مسجلة في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    @if(count($private_courses) > 0)
                        <form method="post" action="{{ route('administrator.courses.confirmation') }}"
                              id="private-form">
                            {{ csrf_field() }}
                            <button class="btn btn-success col-lg-2" id="private-form-save-changes">
                                موافق
                            </button>
                        </form>
                    @endif


                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">الإعلانات في الصفحة الرئيسية</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">العنوان</th>
                                <th class="text-center">الوصف</th>
                                <th class="text-center">رابط التوجيه</th>
                                <th class="text-center">البانر</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($banners) > 0)
                                @foreach($banners as $banner)
                                    <tr class="gradeX">
                                        <td>{{ $banner->title }}</td>
                                        <td>{{ $banner->description }}</td>
                                        <td><a href="{{ $banner->link }}" target="_blank">{{ $banner->link }}</a></td>
                                        <td><a href="#" class="show-banner"
                                               data-banner-link="{{ $banner->banner }}">عرض</a></td>
                                        <td><a href="{{ route('administrator.advertising.banner.edit', $banner->id) }}">تعديل</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5">
                                        <h3 class="mt-15">لاتوجد إعلانات مسجلة في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">رسائل التواصل</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">الإسم</th>
                                <th class="text-center">الموضوع</th>
                                <th class="text-center">البريد الإلكتروني</th>
                                <th class="text-center">رقم الهاتف</th>
                                <th class="text-center">التاريخ</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">الرسالة</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($contact_us) > 0)
                                @foreach($contact_us as $message)
                                    <tr class="gradeX">
                                        <td>{{ $message->name }}</td>
                                        <td>{{ $message->subject }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td class="ltr">{{ $message->phone }}</td>
                                        <td>{{ $message->created_at }}</td>
                                        @if($message->registered == 1)
                                            <td class="text-success">مسجل</td>
                                        @else
                                            <td class="text-danger">زائر</td>
                                        @endif
                                        <td><a href="#" class="show-message" data-message="{{ $message->message }}">عرض</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="7">
                                        <h3 class="mt-15">لاتوجد رسائل تواصل مسجلة في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- /main content -->
@endsection

@section('script-file')
    <script src="{{ asset('js/admin/take-attendance-toggle.js') }}"></script>
    <script src="{{ asset('js/administrator/index.js') }}"></script>
    <script src="{{ asset('js/administrator/show-banners.js') }}"></script>
    <script src="{{ asset('js/administrator/show-contact-us.js') }}"></script>
@endsection