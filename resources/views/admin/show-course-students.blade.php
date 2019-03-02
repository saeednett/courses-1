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
                    <h3 class="panel-title">بيانات الطلاب المسجلين في الدورة</h3>
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
                                <th class="text-center" colspan="7"><h4>{{ $course->title }}</h4></th>
                            </tr>
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
                            <tbody class="text-center">
                            @if(count($reservations) > 0)
                                @foreach($reservations as $reservation)
                                    <tr class="gradeX">
                                        <td>{{ $reservation->student->user->name }}</td>
                                        <td style="direction: ltr;">{{ $reservation->student->user->phone }}</td>
                                        <td style="direction: ltr;">{{ $reservation->student->user->email }}</td>
                                        <td>{{ $reservation->student->year.'-'.$reservation->student->month.'-'.$reservation->student->day }}</td>
                                        <td>{{ $reservation->student->city->name }}</td>
                                        <td>{{ $reservation->student->gender->name }}</td>

                                        @foreach($reservation->student->reservation as $studentReservation)
                                            @if($studentReservation->course_id == $course->id)
                                                @if($studentReservation->confirmation > 0)
                                                    <td class="bg-success text-success">مؤكد</td>
                                                @else
                                                    <td class="bg-danger text-danger">غير مؤكد</td>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="7">
                                        <h3 style="margin-top: 15px">لايوجد طلاب مسجلين في الدورة</h3>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            @if(count($reservations) > 0)
                                <tfoot>
                                <tr>
                                    <th class="text-center">اسم الطالب</th>
                                    <th class="text-center">رقم الهاتف</th>
                                    <th class="text-center">البريد الإلكتروني</th>
                                    <th class="text-center">تاريخ الميلاد</th>
                                    <th class="text-center">المدينة</th>
                                    <th class="text-center">الجنس</th>
                                    <th class="text-center">حالة التسجيل</th>
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