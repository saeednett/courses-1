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
                                <th class="text-center">المدة</th>
                                <th class="text-center">الحضور</th>
                                <th class="text-center">عدد المدربين</th>
                                <th class="text-center">المدينة</th>
                                <th class="text-center" colspan="2">المزيد</th>
                            </tr>
                            </thead>
                            <tbody class="text-center d-none">
                            @if(count($courseAdmin) > 0)
                                @foreach($courseAdmin as $admin)
                                    <tr class="gradeX">
                                        <td>{{ $admin->course->title }}</td>
                                        <td class="ltr">{{ date( 'Y-M-D h:i' ,strtotime($admin->course->created_at)) }}</td>
                                        <td>{{ $admin->course->attendance }}</td>
                                        <td>{{ count($admin->course->reservation) }}</td>
                                        <td>
                                            <?php
                                            $date1 = date_create($admin->course->start_date);
                                            $date2 = date_create($admin->course->end_date);
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
                                        <td>
                                            @if($admin->course->gender == 1)
                                                رجال
                                            @elseif($admin->course->gender == 2)
                                                نساء
                                            @else
                                                رجال ونساء
                                            @endif
                                        </td>
                                        <td>{{ count($admin->course->trainer) }}</td>
                                        <td>{{ $admin->course->city->name }}</td>
                                        @if($admin->role_id == 1)
                                            <td><a href="{{ route('admin.course.edit', $admin->course->identifier) }}">تعديل</a></td>
                                            <td><a href="{{ route('admin.courses.preview', [$admin->course->identifier]) }}" target="_blank">عرض</a></td>
                                        @else
                                            <td><a href="{{ route('admin.course.schedule', $admin->course->identifier) }}">تحضير</a></td>
                                            <td><a href="{{ route('admin.courses.preview', $admin->course->identifier) }}" target="_blank">عرض</a></td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="9">
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