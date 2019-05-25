@extends('center.layouts.master-v-1-1')

@section('title', 'طلاب دورة')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/show-students.css') }}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title"> طلاب دورة  <b>{{ $course->title }}</b></h3>
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
                                <th class="text-center">تاريخ الميلاد</th>
                                <th class="text-center">المدينة</th>
                                <th class="text-center">الجنس</th>
                                <th class="text-center">حالة التسجيل</th>
                            </tr>
                            </thead>
                            <tbody class="text-center d-none">
                            @if(count($reservations) > 0)
                                @foreach($reservations as $reservation)
                                    <tr class="gradeX">
                                        <td class="student_name">{{ trim($reservation->student->first_name." ".$reservation->student->second_name." ".$reservation->student->third_name) }}</td>
                                        <td class="student_phone ltr">{{ $reservation->student->user->phone }}</td>
                                        <td class="student_email ltr">{{ $reservation->student->user->email }}</td>
                                        <td class="student_birth_date">{{ $reservation->student->year.'-'.$reservation->student->month.'-'.$reservation->student->day }}</td>
                                        <td class="student_city">{{ $reservation->student->city->name }}</td>
                                        <td class="student_gender">{{ $reservation->student->gender->name }}</td>

                                        @foreach($reservation->student->reservation as $studentReservation)
                                            @if($studentReservation->course_id == $course->id)
                                                @if($studentReservation->confirmation > 0)
                                                    <td class="course_confirmation bg-success text-success">مؤكد</td>
                                                @else
                                                    <td class="course_confirmation bg-danger text-danger">غير مؤكد</td>
                                                @endif
                                            @endif
                                        @endforeach
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
    <script src="{{ asset('js/center/show-students.js') }}"></script>
@endsection