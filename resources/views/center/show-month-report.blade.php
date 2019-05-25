@extends('center.layouts.master-v-1-1')

@section('content')
    <!-- Main content -->
    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">تقرير الدورات</h3>
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
                                <th class="text-center">قيمة الدورة</th>
                                <th class="text-center">عدد المدربين</th>
                                <th class="text-center">عدد المسؤولين</th>
                                <th class="text-center">عدد المقاعد</th>
                                <th class="text-center">عدد الطلاب</th>
                                <th class="text-center">الشهادات المصدرة</th>
                                <th class="text-center">الحضور</th>
                            </tr>
                            </thead>
                            <tbody class="text-center d-none">
                            @if(count($courses) > 0)
                                @foreach($courses as $course)
                                    <?php $students = 0; ?>
                                    <tr class="gradeX">
                                        <td>{{ $course->title }}</td>
                                        <td>{{ $course->start_date }}</td>
                                        <td>{{ $course->price }}</td>
                                        <td>{{ count($course->trainer) }}</td>
                                        <td>{{ count($course->admin) }}</td>
                                        <td>{{ $course->attendance }}</td>

                                        @if(count($course->reservation) > 0)
                                            @foreach($course->reservation as $reservation)
                                                @if($reservation->confirmation == 1)
                                                    <?php $students += 1; ?>
                                                @endif
                                            @endforeach
                                            <td>{{ $students  }}</td>
                                        @else
                                            <td>0</td>
                                        @endif


                                        <td>{{ count($course->certificate) }}</td>

                                        @if($course->gender == 1)
                                            <td>رجال</td>
                                        @elseif($course->gender == 2)
                                            <td>نساء</td>
                                        @else
                                            <td>رجال ونساء</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="9">
                                        <h3 class="mt-15">لاتوجد دورات مسجلة لهذا التاريخ </h3>
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