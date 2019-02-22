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
                                <th class="text-center" colspan="6"><h4> {{ $course->title }} </h4></th>
                            </tr>
                            <tr>
                                <th class="text-center">اسم الطالب</th>
                                <th class="text-center">تاريخ الدورة</th>
                                <th class="text-center">اسم صاحب الحساب</th>
                                <th class="text-center">رقم الحساب</th>
                                <th class="text-center" colspan="2">خيارات</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @if(count($course->appointment->reservation) > 0)
                                @foreach($course->appointment->reservation as $reservation)
                                    <tr class="gradeX">
                                        <td>{{ $reservation->student->user->name }}</td>
                                        <td class="ltr">{{ date( 'Y-M-D h:i' ,strtotime($course->created_at)) }}</td>
                                        <td>{{ $reservation->payment->account_owner }}</td>

                                        <td>{{ $reservation->payment->account_number }}</td>

                                        <td>
                                            <a href="#">تم الدفع</a>
                                        </td>

                                        <td>
                                            <a href="#">لم يتم الدفع</a>
                                        </td>
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
                            @if(count($course->appointment->reservation) > 2)
                                <tfoot>
                                <tr>
                                    <th class="text-center">اسم الطالب</th>
                                    <th class="text-center">تاريخ الدورة</th>
                                    <th class="text-center">اسم صاحب الحساب</th>
                                    <th class="text-center">رقم الحساب</th>
                                    <th class="text-center" colspan="2">خيارات</th></th>
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