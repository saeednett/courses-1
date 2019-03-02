@extends('student.master-v-1-1')

@section('title', 'حجز دورة')

@section('guest-links')
    <a class="dropdown-item" href="{{ route('account.login') }}">تسجيل الدخول</a>
    <a class="dropdown-item" href="{{ route('account.register') }}">تسجيل مستخدم جديد</a>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/student/book-course.css') }}">
@endsection

@section('script-file')
    <script src="{{ asset('js/student/book-course.js') }}"></script>
@endsection


@section('content')
    <div class="container mb-2">
        <div class="row justify-content-center mt-lg-2">
            <div class="col-lg-10 col-md-12 col-sm-12 col-12">
                <form class="mb-0" id="reserve-course" method="post" action="{{ route('account.course.booking.reserve', $course->identifier) }}">
                    {{ csrf_field() }}

                    <div class="row justify-content-center mt-2">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="alert alert-warning rounded">
                                <div class="row">
                                    <div class="col-lg-2 col-md-12 col-sm-12 col-12 order-lg-last order-first text-center">
                                        <div class="text-center timer">
                                            <h1 class="p-0 m-0" id="counter">10:00</h1>
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-md-12 col-sm-12 col-12 text-lg-right text-center">
                                        <p class="m-0 pt-13" id="counter"> سوف يتم اعادة توجيهك
                                            للصفحة السابقة في حال انتهى
                                            الموقت ولم تقم بإنهاء الحجز</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-2">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 order-lg-last">

                            <div class="ticket-information">
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <h4 class="text-right pr-2">معلومات التذكرة</h4>
                                    </div>

                                    <div class="col-12">
                                        <div class="block rounded mt-0 mb-lg-4">
                                            <div class="row justify-content-end">
                                                <div class="col-12 text-right">


                                                    <div class="row info">
                                                        <div class="col-lg-5 col-md-5 col-sm-5 col-5 text-right rtl order-last">
                                                            <i class="fa fa-book labels-icon"></i>
                                                            <span class="">عنوان الدورة:</span>
                                                        </div>
                                                        <div class="col-lg-7 col-md-7 col-sm-7 col-7 text-center">
                                                            <p class="mt-0 mb-0"><b>{{ $course->title }}</b></p>
                                                        </div>
                                                    </div>

                                                    <div class="row info">
                                                        <div class="col-lg-4 col-md-3 col-sm-4 col-5 text-right rtl order-last">
                                                            <i class="fa fa-money labels-icon"></i>
                                                            <span class="">المبلغ:</span>
                                                        </div>
                                                        <div class="col-lg-8 col-md-9 col-sm-5 col-7 text-center">
                                                            @if($course->type == 'free')
                                                                <p class="mt-0 mb-0 text-muted rtl"><b>مجانية</b></p>
                                                            @else
                                                                <p class="mt-0 mb-0 text-muted rtl"><b>{{ $course->price }}ريال</b></p>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="row info">
                                                        <div class="col-lg-4 col-md-3 col-sm-8 col-5 text-right rtl order-last">
                                                            <i class="fa fa-ticket labels-icon"></i>
                                                            <span class="">التذكرة:</span>
                                                        </div>
                                                        <div class="col-lg-8 col-md-9 col-sm-5 col-7 text-center">
                                                            ١ تذكرة واحدة
                                                        </div>
                                                    </div>

                                                    <div class="row info">
                                                        <div class="col-lg-4 col-md-3 col-sm-5 col-5 text-right rtl order-last">
                                                            <i class="fa fa-clock-o labels-icon"></i>
                                                            <span class="">المدة:</span>
                                                        </div>
                                                        <div class="col-lg-8 col-md-9 col-sm-5 col-7 text-center rtl">
                                                            <?php
                                                            $date1 = date_create($course->start_date);
                                                            $date2 = date_create($course->finish_date);
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
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="row info">
                                                        <div class="col-lg-12 text-center pt-2">
                                                            <h4 class="text-danger rtl mb-0 mt-0">الاجمالي
                                                                : {{ $course->price }}
                                                                ريال </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rules-information mt-4">
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <h4 class="text-right pr-2">ملاحظات مهمة</h4>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="block rounded mt-0 pb-1">
                                            <div class="row justify-content-end">
                                                <div class="col-lg-12 text-right">
                                                    <ul class="rtl text-right custom-rules">
                                                        <li>
                                                            <span class="fa fa-arrow-circle-o-left text-custom"></span>
                                                            <span>16 سنة أو أكبر</span>
                                                        </li>

                                                        <li>
                                                            <span class="fa fa-arrow-circle-o-left text-custom"></span>
                                                            <span>التذكرة صالحة لشخص واحد فقط</span>
                                                        </li>

                                                        <li>
                                                            <span class="fa fa-arrow-circle-o-left text-custom"></span>
                                                            <span>فضلاً أحضر معك تذكرتك الإلكترونية لتسهيل إجراءات الدخول يوم الفعالية.</span>
                                                        </li>

                                                        <li>
                                                            <span class="fa  fa-arrow-circle-o-left text-custom"></span>
                                                            <span>لن يتم إصدار التذكرة الإ بعد الدفع</span>
                                                        </li>

                                                        <li>
                                                            <span class="fa fa-arrow-circle-o-left text-custom"></span>
                                                            <span>ممنوع اصطحاب الأطفال</span>
                                                        </li>

                                                        <li>
                                                            <span class="fa fa-arrow-circle-o-left text-custom"></span>
                                                            <span>ممنوع التدخين</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="coupon-section">
                                <div class="row mt-lg-0 mt-4">
                                    <div class="col-12 text-right">
                                        <h4 class="text-right pr-2">أكواد الخصم</h4>
                                    </div>


                                    <div class="col-12">
                                        <div class="block rounded mt-0">
                                            <div class="row justify-content-end">
                                                <div class="col-12 text-right">
                                                    <p class="m-0">كود الخصم</p>
                                                </div>
                                            </div>

                                            <div class="row justify-content-center mt-4">

                                                <div class="col-lg-8 col-md-12 col-sm-12 col-12 order-lg-last order-first">
                                                    <input type="text" class="form-control text-center"
                                                           name="coupon_code"
                                                           placeholder="كود الخصم" autocomplete="off">

                                                    <div class="invalid-feedback text-center d-block"
                                                         id="coupon_error_description">
                                                    </div>

                                                </div>

                                                <div class="col-lg-4 col-md-6 col-sm-6 col-6 text-right mt-lg-0 mt-2">
                                                    <button class="btn btn-block btn-success" id="check_coupon_code">
                                                        التحقق
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="payment-section mt-4 mb-2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4 class="text-right pr-2">طريقة الدفع</h4>
                                    </div>

                                    <div class="col-12">
                                        <div class="block mt-0 rounded">
                                            <div class="bank-selection">
                                                <input type="hidden" name="center" value="{{ $course->center->id }}">
                                                <select class="custom-select {{ $errors->has('bank') ? ' is-invalid' : '' }} custom-input"
                                                        name="bank" required>
                                                    <option>- البنك -</option>
                                                    @foreach($accounts as $account)
                                                        @if($account->bank->id  == $course->center->account[0]->bank->id)
                                                            <option value="{{ $account->bank->id }}"
                                                                    selected>{{ $account->bank->name }}</option>
                                                        @else
                                                            <option value="{{ $account->bank->id }}">{{ $account->bank->name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="bank-information mt-4">

                                                <div class="account-information">

                                                    <div class="row justify-content-center">
                                                        <div class="col-lg-8">
                                                            <img src="{{ $course->center->account[0]->bank->logo }}"
                                                                 class="d-block ml-auto w-100" alt="Bank Logo">
                                                        </div>
                                                    </div>

                                                    <div class="row justify-content-center mt-4">
                                                        <div class="col-lg-8 text-right">
                                                            <p class="mb-0 rtl"> البنك
                                                                : {{ $course->center->account[0]->bank->name }} </p>
                                                        </div>
                                                    </div>

                                                    <div class="row justify-content-center mt-0">
                                                        <div class="col-lg-8 text-right">
                                                            <p class="m-0 rtl"> اسم الحساب
                                                                : {{ $course->center->account[0]->account_owner }} </p>
                                                        </div>
                                                    </div>

                                                    <div class="row justify-content-center mt-0">
                                                        <div class="col-lg-8 text-right">
                                                            <p class="m-0 rtl"> رقم الحساب
                                                                : {{ $course->center->account[0]->account_number }} </p>
                                                        </div>
                                                    </div>

                                                    <div class="row justify-content-center mt-0">
                                                        <div class="col-lg-8 text-right">
                                                            <p class="m-0 rtl"> رقم الايبان
                                                                : {{ $course->center->account[0]->account_number }} </p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row justify-content-center mt-lg-2 mb-3">
            <div class="col-lg-10 col-md-12 col-sm-12 col-12">
                <div class="row justify-content-end">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="submit-section mt-0 mb-0">
                            <div class="row justify-content-end">
                                <div class="col-12">
                                    <button class="btn btn-block custom-btn" form="reserve-course">احجز التذكرة</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection