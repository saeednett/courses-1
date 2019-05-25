@extends('center.layouts.master-v-1-1')

@section('title', 'الدورات')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/show-courses.css') }}">
@endsection

@section('content')
    <!-- Main content -->

    <div class="page-cover">

        <div class="search-holder">
            <div class="h-55 border-bottom-1">
                <div class="separator-button pull-right">
                    <button class="btn-danger" id="close-button">اغلاق</button>
                </div>
                <div class="separator-input pull-right">
                    <input type="text" class="text-center" id="key" placeholder="اسم الدورة" maxlength="30">
                </div>
                <div class="separator-button pull-left border-left">
                    <button class="btn-success" id="search-button">بحث</button>
                </div>
            </div>

            <div class="text-center mt-20">
                <p class="size-20 text-danger" id="error_description"></p>
                <p class="size-20 text-success" id="success_description"></p>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات الدورات المسجلة في النظام</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="search" href="#"><i class="icon-search"></i></a></li>
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
                                <th class="text-center">عدد المقاعد</th>
                                <th class="text-center">عدد الطلاب</th>
                                <th class="text-center">المدة</th>
                                <th class="text-center">الحضور</th>
                                <th class="text-center">عدد المدربين</th>
                                <th class="text-center">المدينة</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center" colspan="2">المزيد</th>
                            </tr>
                            </thead>
                            <tbody class="text-center d-none">
                            @if(count($courses) > 0)
                                @foreach($courses as $course)
                                    <tr class="gradeX">
                                        <td class="course_title">{{ $course->title }}</td>
                                        <td class="course_date ltr">{{ date( 'Y-m-d' ,strtotime($course->start_date)) }}</td>
                                        <td class="course_attendance">{{ $course->attendance }}</td>

                                        <?php $total = 0; ?>
                                        @foreach($course->reservation as $reservation)
                                            @if($reservation->confirmation == 1)
                                                <?php $total++; ?>
                                            @endif
                                        @endforeach

                                        <td class="course_reservation">{{ $total }}</td>


                                        <td class="course_days">
                                            <?php
                                            $date1 = date_create($course->start_date);
                                            $date2 = date_create($course->end_date);
                                            $diff = date_diff($date1, $date2);
                                            $days = $diff->format("%a");
                                            if ($days == 1) {
                                                echo $days . " يوم ";
                                            } elseif ($days == 2) {
                                                echo $days . " يومين ";
                                            } elseif ($days > 2 && $days <= 10) {
                                                echo $days . " أيام ";
                                            } else {
                                                echo $days . " يوم ";
                                            }
                                            ?>
                                        </td>
                                        <td class="course_gender">
                                            @if($course->gender == 1)
                                                رجال
                                            @elseif($course->gender == 2)
                                                نساء
                                            @else
                                                رجال ونساء
                                            @endif
                                        </td>
                                        <td class="course_trainer">{{ count($course->trainer) }}</td>
                                        <td class="course_city">{{ $course->city->name }}</td>

                                        @if($course->validation == 1)
                                            <td class="course_validation text-success">مؤكدة</td>
                                        @else
                                            <td class="course_validation text-danger">غير مؤكدة</td>
                                        @endif

                                        @switch($type)
                                            @case("Course")
                                            <td class="course_edit">
                                                <a href="{{ route('center.course.edit', $course->identifier) }}">تعديل</a>
                                            </td>
                                            <td class="course_view"><a
                                                        href="{{ route('center.courses.preview', [$course->identifier]) }}"
                                                        target="_blank">عرض</a></td>
                                            @break

                                            @case("Student")
                                            <td class="course_student" colspan="2">
                                                <a href="{{ route('center.students.show', $course->identifier) }}">عرض الطلاب</a>
                                            </td>

                                            @break

                                            @case("Payment")
                                            <td class="course_student" colspan="2">
                                                <a href="{{ route('center.courses.payment', $course->identifier) }}">تأكيد
                                                    الدفع</a>
                                            </td>
                                            @break

                                            @case("Attendance")
                                            <td class="course_student" colspan="2">
                                                <a href="{{ route('center.courses.attendance', $course->identifier) }}">عرض سجل الحضور</a>
                                            </td>
                                            @break

                                            @case("Certificate")
                                            <td class="course_student" colspan="2">
                                                <a href="{{ route('center.courses.certificates', $course->identifier) }}">عرض الشهادات</a>
                                            </td>
                                            @break

                                            @case("TakeAttendance")
                                            <td class="course_student" colspan="2">
                                                <a href="{{ route('center.course.schedule', $course->identifier) }}">عرض الجدول</a>
                                            </td>
                                            @break

                                            @case("GenerateCertificate")
                                            <td class="course_student" colspan="2">
                                                <a href="{{ route('center.courses.certificates.generate', $course->identifier) }}">إصدار الشهادات</a>
                                            </td>
                                            @break


                                        @endswitch
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="11">
                                        <h3 class="mt-15">لاتوجد دورات مسجلة في النظام</h3>
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
    <script src="{{ asset('js/center/show-courses.js') }}"></script>
@endsection