@extends('center.layouts.master-v-1-1')

@section('title', 'سجل حضور الطلاب')

@section('style-file')

@endsection

@section('content')
    <!-- Main content -->
    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">سجل حضور الطلاب</h3>
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
                                <th class="text-center">اسم الطالب</th>
                                <th class="text-center">رقم الهاتف</th>
                                <th class="text-center">البريد الإلكتروني</th>
                                <th class="text-center">الحضور</th>
                                <th class="text-center">مدة الدورة</th>
                                <th class="text-center">التفاصيل</th>
                            </tr>
                            </thead>
                            <tbody class="text-center d-none">
                            @if(count($reservations) > 0)
                                @foreach($reservations as $reservation)
                                    <tr class="gradeX">
                                        <td class="student-name">{{ trim($reservation->student->first_name." ".$reservation->student->second_name." ".$reservation->student->third_name) }}</td>
                                        <td class="student-phone ltr">{{ $reservation->student->user->phone }}</td>
                                        <td class="student-email ltr">{{ $reservation->student->user->email }}</td>
                                        <?php $total = 0; ?>
                                        @foreach($reservation->student->reservation as $studentReservation)
                                            @if($studentReservation->course_id == $course->id)
                                                <?php $total++; ?>
                                            @endif
                                        @endforeach
                                        <td class="student-attendance">{{ $total }}</td>
                                        <td class="course-days">{{ $days }}</td>
                                        <td class="more-details"><a href="{{ route('center.student.attendance.details', [$reservation->course->identifier, $reservation->student->id]) }}">المزيد</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="7">
                                        <h3 class="mt-15">لايوجد طلاب مسجلين في هذه الدورة</h3>
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
    <script src="{{ asset('js/center/show-course-attendance.js') }}"></script>
@endsection