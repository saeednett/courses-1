@extends('center.layouts.master-v-1-1')

@section('title', 'تاأكيد الدفع')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/confirm-payment.css') }}">
@endsection

@section('content')

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
        <div class="modal fade" id="warning-model" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header text-right">
                        <h4 class="modal-title text-danger close" data-dismiss="modal" style="float: right;">تنبيه!</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p class="text-danger">عند إلغاء تأكيد الدفع سوف يتم حذف تذكرة الحضور إلى ان يتم تأكيد الدفع</p>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success" id="agree-warning">موافق</button>
                        <button class="btn btn-danger" id="cancel-warning">إلغاء</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">بيانات الطلاب المسجلين في الدورة</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="search" href="#"><i class="icon-search"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <form method="post"
                                  action="{{ route('center.courses.payment.confirm',$reservations[0]->course->identifier) }}" id="confirmation-form">
                                {{ csrf_field() }}
                                <thead>
                                <tr>

                                        <th class="text-center" colspan="6">
                                            <h4> {{ $reservations[0]->course->title }} </h4></th>
                                        <td class="text-center">
                                            <button class="btn btn-success btn-block"
                                                    id="confirmation-form-save-changes">
                                                حفظ
                                            </button>
                                        </td>
                                </tr>
                                <tr>
                                    <th class="text-center">اسم الطالب</th>
                                    <th class="text-center">تاريخ الدورة</th>
                                    <th class="text-center">اسم صاحب الحساب</th>
                                    <th class="text-center">رقم الحساب</th>
                                    <th class="text-center">الخصم</th>
                                    <th class="text-center">الإجمالي</th>
                                    <th class="text-center" colspan="2">خيارات</th>
                                </tr>
                                </thead>
                                <tbody class="text-center">
                                @if(count($reservations) > 0)
                                    <?php $counter = 0; ?>
                                    @foreach($reservations as $reservation)
                                        <?php $counter++; ?>
                                        <tr class="gradeX">
                                            <td class="student-name pt-17">
                                                {{ $reservation->student->first_name." ".$reservation->student->second_name." ".$reservation->student->third_name }}
                                                <input type="hidden" name="student[]"
                                                       value="{{ $reservation->student->id }}">
                                            </td>
                                            <td class="course-date pt-17 ltr">{{ date( 'Y-m-d' ,strtotime($reservation->course->start_date)) }}</td>

                                            @if(!is_null($reservation->payment))
                                                <td class="account-owner pt-17">{{ $reservation->payment->account_owner }}</td>
                                                <td class="account-number pt-17">{{ $reservation->payment->account_number }}</td>
                                            @else
                                                <td class="account-owner text-danger pt-17">لايوجد</td>
                                                <td class="account-number text-danger pt-17">لايوجد</td>
                                            @endif
                                            @if($reservation->coupon_id > 0)
                                                <td class="course-discount pt-17 text-success">{{ $reservation->coupon->discount }}</td>
                                                <?php
                                                $discount = ($reservation->course->price * $reservation->coupon->discount) / 100;
                                                $amount = $reservation->course->price - $discount;
                                                ?>
                                                <td class="course-total pt-17">{{ $amount }}</td>
                                            @else
                                                <td class="course-discount pt-17 text-danger">لايوجد</td>
                                                <td class="course-total pt-17">{{ $reservation->course->price  }}</td>
                                            @endif

                                            @if($reservation->confirmation == 1)
                                                <td>
                                                    <input type="checkbox" data-toggle="toggle" class="toggle-input course-confirmation" checked>
                                                    <input type="hidden" name="payment[]" value="1" required>
                                                    <input type="hidden" name="identifier[]"
                                                           value="{{ $reservation->identifier }}" required>
                                                </td>
                                            @else
                                                <td>
                                                    <input type="checkbox" data-toggle="toggle" class="toggle-input course-confirmation">
                                                    <input type="hidden" name="payment[]" value="0" required>
                                                    <input type="hidden" name="identifier[]"
                                                           value="{{ $reservation->identifier }}" required>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="gradeX">
                                        <td class="text-danger" colspan="7">
                                            <h3 class="mt-15">لايوجد طلاب مسجلين في الدورة</h3>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
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
    <script src="{{ asset('js/main/toggle-button.js') }}"></script>
    <script src="{{ asset('js/center/confirm-payments.js') }}"></script>
@endsection