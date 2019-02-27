@extends('admin.layouts.master')

@section('content')
    <!-- Main content -->
    <style>
        .warning-color {
            color: #fff466;
        }
    </style>
    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات الدورات المسجلة في النظام</h3>
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
                                <th class="text-center">عدد المقاعد</th>
                                <th class="text-center">عدد الطلاب</th>
                                <th class="text-center">المدربين</th>
                                <th class="text-center">الحضور</th>
                                <th class="text-center">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($courses) > 0)
                                @foreach($courses as $course)
                                    <tr class="gradeX">
                                        <td>{{ $course->course->title }}</td>
                                        <td class="ltr">{{ date( 'Y-M-D h:i' ,strtotime($course->course->created_at)) }}</td>
                                        <td>{{ $course->course->appointment->attendance }}</td>
                                        <td>{{ count($course->course->appointment->reservation) }}</td>
                                        <td>{{ count($course->course->trainer) }}</td>
                                        <td>
                                            @if($course->course->appointment->gender == 1)
                                                رجال
                                            @elseif($course->course->appointment->gender == 2)
                                                نساء
                                            @else
                                                رجال ونساء
                                            @endif
                                        </td>
                                        @if($course->role_id == 1)
                                            <td colspan="2">
                                                <a href="{{ route('admin.course.students.show', $course->course->identifier) }}">عرض الطلاب</a>
                                            </td>
                                        @else
                                            <td colspan="2">
                                                <a href="{{ route('admin.course.students.show', $course->course->identifier) }}">عرض الطلاب</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5">
                                        <h3 style="margin-top: 15px">لاتوجد دورات مسجلة في النظام</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($courses) > 0)
                                <tfoot>
                                <tr>
                                    <th class="text-center">اسم الدورة</th>
                                    <th class="text-center">تاريخ الدورة</th>
                                    <th class="text-center">عدد المقاعد</th>
                                    <th class="text-center">عدد الطلاب</th>
                                    <th class="text-center">المدربين</th>
                                    <th class="text-center">الحضور</th>
                                    <th class="text-center">خيارات</th>
                                </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /main content -->
@endsection