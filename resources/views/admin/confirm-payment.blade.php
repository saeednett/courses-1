@extends('admin.layouts.master')

@section('content')
    <!-- Main content -->
    <style>
        .warning-color {
            color: #fff466;
        }

        .pt-17 {
            padding-top: 17px !important;
        }
    </style>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات الطلاب المسجلين في الدورة</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center" colspan="4"><h4> {{ $course->title }} </h4></th>
                                <td class="text-center"> <button class="btn btn-success btn-block" id="save">حفظ</button> </td>
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
                                <?php $counter = 0; ?>
                                @foreach($course->appointment->reservation as $reservation)
                                    @if($reservation->confirmation == 0)
                                        <?php $counter++; ?>
                                        <tr class="gradeX">
                                            <td class="pt-17">{{ $reservation->student->user->name }}</td>
                                            <td class="pt-17 ltr">{{ date( 'Y-M-D h:i' ,strtotime($course->created_at)) }}</td>
                                            <td class="pt-17">{{ $reservation->payment->account_owner }}</td>

                                            <td class="pt-17">{{ $reservation->payment->account_number }}</td>

                                            {{--<td>--}}
                                            {{--<a href="#">تم الدفع</a>--}}
                                            {{--</td>--}}

                                            {{--<td>--}}
                                            {{--<a href="#">لم يتم الدفع</a>--}}
                                            {{--</td>--}}

                                            <td>

                                                <input type="checkbox" data-toggle="toggle" name="payment">
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                @if($counter == 0)
                                    <tr class="gradeX">
                                        <td colspan="6"><h3 class="text-success" style="padding-top: 8px;">تم تأكيد حجز جميع الطلاب المسجلين</h3></td>
                                    </tr>
                                @endif
                            @else
                                <tr class="gradeX">
                                    <td class="text-danger" colspan="5">
                                        <h3 style="margin-top: 15px">لايوجد طلاب مسجلين في الدورة</h3>
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
                                    <th class="text-center" colspan="2">خيارات</th>
                                    </th>
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

@section('script-file')
    <script src="{{ asset('js/admin/confirm-payment-toggle.js') }}"></script>
    <script>
        $(document).ready(function () {

            $('#save').on('click', function () {
                alert("hello");
            });
        });
    </script>
@endsection