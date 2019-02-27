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
                                <th class="text-center" colspan="8"><h4>{{ $course_->title }}</h4></th>
                            </tr>
                            <tr>
                                <th class="text-center">اسم الطالب</th>
                                <th class="text-center">رقم الهاتف</th>
                                <th class="text-center">تاريخ الميلاد</th>
                                <th class="text-center">المدينة</th>
                                <th class="text-center">اسم صاحب الحساب</th>
                                <th class="text-center">رقم الحساب</th>
                                <th class="text-center">الخصم</th>
                                <th class="text-center">حالة الدفع</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($students) > 0)
                                @foreach($students as $student)
                                    <tr class="gradeX">
                                        <td>{{ $student->student->user->name }}</td>
                                        <td style="direction: ltr;">{{ $student->student->user->phone }}</td>
                                        <td>{{ $student->student->year.'-'.$student->student->month.'-'.$student->student->day }}</td>
                                        <td>{{ $student->student->city->name }}</td>
                                        @foreach($student->student->reservation as $reservation)
                                            @if($reservation->appointment_id == $course_->appointment->id)
                                                <td>{{ $reservation->payment->account_owner }}</td>
                                                <td>{{ $reservation->payment->account_number }}</td>
                                                @if($reservation->coupon_id > 0)
                                                    <td class="pt-17 text-success">
                                                        %{{ $reservation->coupon->discount }}</td>
                                                @else
                                                    <td class="pt-17 text-danger">لايوجد</td>
                                                @endif

                                                @if($reservation->confirmation > 0)
                                                    <td class="bg-success">مؤكد</td>
                                                @else
                                                    <td class="bg-danger">غير مؤكد</td>
                                                @endif
                                            @endif
                                        @endforeach
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
                            @if(count($students) > 0)
                                <tfoot>
                                <tr>
                                    <th class="text-center">اسم الطالب</th>
                                    <th class="text-center">رقم الهاتف</th>
                                    <th class="text-center">تاريخ الميلاد</th>
                                    <th class="text-center">المدينة</th>
                                    <th class="text-center">اسم صاحب الحساب</th>
                                    <th class="text-center">رقم الحساب</th>
                                    <th class="text-center">الخصم</th>
                                    <th class="text-center">حالة الدفع</th>
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