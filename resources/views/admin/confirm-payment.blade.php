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


    @if(session()->has('success'))
        <div class="" id="editing-note"
             style="width: 100%; height: 100%; z-index: 1500; background: #bbb4b491; position: fixed; top: 0; left: 0; right: 0; margin: 0; padding: 0;">
            <div class="col-lg-4 text-center"
                 style="height: 150px; position: absolute; background: #a5a5a5; border-radius: 10px; margin: auto; top: 0; left: 0; right: 0; bottom: 0; padding: 20px;">
                <h2>ملاحظة</h2>
                <p>** تم حفظ معلومات تأكيد الدفع لن تستطيع تغيرها في حال تم بدء الدورة **</p>
                <button class="btn btn-success" id="agree">موافق</button>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات الطلاب المسجلين في الدورة</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <form method="post"
                                  action="{{ route('admin.courses.payment.confirm',$course->identifier) }}">
                                {{ csrf_field() }}
                                <thead>
                                <tr>
                                    @if(count($course->reservation) > 0)
                                        <th class="text-center" colspan="5"><h4> {{ $course->title }} </h4></th>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-block" id="save">حفظ</button>
                                        </td>
                                    @else
                                        <th class="text-center" colspan="6"><h4> {{ $course->title }} </h4></th>
                                    @endif
                                </tr>
                                <tr>
                                    <th class="text-center">اسم الطالب</th>
                                    <th class="text-center">تاريخ الدورة</th>
                                    <th class="text-center">اسم صاحب الحساب</th>
                                    <th class="text-center">رقم الحساب</th>
                                    <th class="text-center">الخصم</th>
                                    <th class="text-center" colspan="2">خيارات</th>
                                </tr>
                                </thead>
                                <tbody class="text-center">
                                @if(count($course->reservation) > 0)
                                    <?php $counter = 0; ?>
                                    @foreach($course->reservation as $reservation)
                                        @if($reservation->confirmation == 0)
                                            <?php $counter++; ?>
                                            <tr class="gradeX">
                                                <td class="pt-17">
                                                    {{ $reservation->student->user->name }}
                                                    <input type="hidden" name="student[]"
                                                           value="{{ $reservation->student->id }}">
                                                </td>
                                                <td class="pt-17 ltr">{{ date( 'Y-M-D h:i' ,strtotime($course->created_at)) }}</td>
                                                <td class="pt-17">{{ $reservation->payment->account_owner }}</td>
                                                <td class="pt-17">{{ $reservation->payment->account_number }}</td>
                                                @if($reservation->coupon_id > 0)
                                                    <td class="pt-17 text-success">
                                                        %{{ $reservation->coupon->discount }}</td>
                                                @else
                                                    <td class="pt-17 text-danger">لايوجد</td>
                                                @endif
                                                <td>
                                                    <input type="checkbox" data-toggle="toggle" class="payment-toggle">
                                                    <input type="hidden" name="payment[]" value="0" required>
                                                    <input type="hidden" name="identifier[]"
                                                           value="{{ $reservation->identifier }}" required>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    @if($counter == 0)
                                        <tr class="gradeX">
                                            <td colspan="6"><h3 class="text-success" style="padding-top: 8px;">تم تأكيد
                                                    حجز جميع الطلاب المسجلين</h3></td>
                                        </tr>
                                    @endif
                                @else
                                    <tr class="gradeX">
                                        <td class="text-danger" colspan="6">
                                            <h3 style="margin-top: 15px">لايوجد طلاب مسجلين في الدورة</h3>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                                @if(count($course->reservation) > 2)
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
                            </form>
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

            $('.payment-toggle').on('change', function () {
                let value = $(this).prop('checked');
                if (value) {
                    $(this).parent().next().val(1);
                } else {
                    $(this).parent().next().val(0);
                }
            });

            $('#agree').on('click', function () {
                $('#editing-note').fadeOut('slow', function () {
                    $(this).remove();
                });
            });
        });
    </script>
@endsection