@extends('administrator.layouts.master-statistics')

@section('title', 'تفعيل الدورات الخاصة')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/confirm-private-courses.css') }}">
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
                    <h3 class="panel-title">تفعيل  الدورات الخاصة</h3>
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
                                                   form="public-form">
                                            <input type="hidden" name="type" value="private" form="public-form">
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
                                        <h3 class="mt-15">لاتوجد دورات خاصة مسجلة في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>

                    @if(count($private_courses) > 0)
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

    <!-- /main content -->
@endsection

@section('script-file')
    <script src="{{ asset('js/admin/take-attendance-toggle.js') }}"></script>
    <script src="{{ asset('js/administrator/confirm-private-courses.js') }}"></script>
@endsection