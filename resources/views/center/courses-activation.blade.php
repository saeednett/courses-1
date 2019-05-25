@extends('center.layouts.master-v-1-1')

@section('title', 'تفعيل الدورات')

@section('content')

    @if($errors->any())
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
                        <li>{{ session('success') }}</li>
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
                        <p class="text-danger">عند إلغاء تفعيل الدورات فإنها لن تظهر للطلاب ولن يتم التسجيل فيها</p>
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
                    <h3 class="panel-title">تعليق الدورات وتفعيلها</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="search" href="#"><i class="icon-search"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <form method="post"
                                  action="{{ route('center.courses.activation.confirm') }}" id="confirmation-form">
                                {{ csrf_field() }}
                                <thead>
                                <tr>
                                    <th class="text-center" colspan="7"><h4> في حال تم تعليق الدورة فان الطلاب لن يتمكنوا من التسجيل حتى يتم إعادة تفعيلها </h4></th>
                                </tr>
                                <tr>
                                    <th class="text-center">الدورة</th>
                                    <th class="text-center">تاريخ الدورة</th>
                                    <th class="text-center">التصنيف</th>
                                    <th class="text-center">المقاعد</th>
                                    <th class="text-center">الطلاب</th>
                                    <th class="text-center">الحضور</th>
                                    <th class="text-center">خيارات</th>
                                </tr>
                                </thead>
                                <tbody class="text-center">
                                @if(count($courses) > 0)
                                    @foreach($courses as $course)
                                        <tr class="gradeX">
                                            <td class="course-title pt-17">
                                                {{ $course->title }}
                                            </td>
                                            <td class="course-date pt-17 ltr">{{ date( 'Y-m-d' ,strtotime($course->start_date)) }}</td>
                                            <td class="course-category pt-17">{{ $course->category->name }}</td>
                                            <td class="course-attendance pt-17">{{ $course->attendance }}</td>
                                            <td class="course-reservation pt-17">{{ count($course->reservation) }}</td>
                                            <td class="course-gender pt-17">
                                                @if($course->gender == 1)
                                                    رجال
                                                @elseif($course->gender == 2)
                                                    نساء
                                                @else
                                                    رجال ونساء
                                                @endif
                                            </td>
                                            <td>
                                                @if($course->activation == 1)
                                                    <input type="checkbox" data-toggle="toggle"
                                                           class="toggle-input course-activation" checked>
                                                @else
                                                    <input type="checkbox" data-toggle="toggle"
                                                           class="toggle-input course-activation">
                                                @endif
                                                <input type="hidden" name="activation[]" value="{{ $course->activation }}" required>
                                                <input type="hidden" class="course-identifier" name="course[]"
                                                       value="{{ $course->identifier }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="gradeX">
                                        <td class="text-danger" colspan="8">
                                            <h3 class="mt-15">لايوجد توجد دورات يمكن تعليقها</h3>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </form>
                        </table>
                        <button class="btn btn-success col-lg-2 col-md-4" id="confirmation-form-save-changes">حفظ</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main content -->
@endsection

@section('script-file')
    <script src="{{ asset('js/main/toggle-button.js') }}"></script>
    <script src="{{ asset('js/center/courses-activation.js') }}"></script>
@endsection