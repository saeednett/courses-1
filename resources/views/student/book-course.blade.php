@extends('student.master-v-1-1')

@section('title', 'الفعالبات')

@section('guest-links')
    <a class="dropdown-item" href="{{ route('account.login') }}">تسجيل الدخول</a>
    <a class="dropdown-item" href="{{ route('account.register') }}">تسجيل مستخدم جديد</a>
@endsection

@section('style-file')

@endsection

@section('script-file')
    <script>
        $('.carousel').carousel();

        let min = 9;
        let sec = 60;
        if (min == 0 && sec == 0) {
            alert("yes");
        }

        let countdown = setInterval(function () {
            if (min == 0 && sec == 0) {
                $('#counter').text(min + ":" + sec);
                clearInterval(countdown);
                history.back();
            } else {
                if (sec == 0) {
                    min--;
                    sec = 59;
                } else {
                    sec--;
                }
            }
            $('#counter').text(min + ":" + sec);
        }, 1000);


        $("select[name=bank]").on('change', function () {
            var bank = $(this).val();
            var center = $("input[name=center]").val();
            $.ajax({
                url: "http://127.0.0.1:8000/api/v-1/account/center="+center+"&bank="+bank,
                type: "get",
                success: function (data, result) {
                    $(".account-information").children().remove();
                    $(".account-information").append(" <div class='row justify-content-center'> <div class='col-lg-8'> <img src='"+data['response']['logo']+"' class='d-block ml-auto' alt='Bank Logo' style='width: 100%; height: 10%;'> </div> </div> <div class='row justify-content-center mt-4'> <div class='col-lg-8 text-right'> <p class='mb-0 rtl'> البنك : "+data['response']['name']+" </p></div> </div> <div class='row justify-content-center mt-0'> <div class='col-lg-8 text-right'> <p class='m-0 rtl'> اسم الحساب : "+data['response']['account_owner']+" </p> </div> </div> <div class='row justify-content-center mt-0'> <div class='col-lg-8 text-right'> <p class='m-0 rtl'>  رقم الحساب : "+data['response']['account_number']+" </p> </div> </div> <div class='row justify-content-center mt-0'> <div class='col-lg-8 text-right'>  <p class='m-0 rtl'>  رقم الايبان : "+data['response']['account_number']+" </p> </div> </div> ");
                },
                error: function () {
                    alert("هناك خطأ الرجاء المحاولة لاحقا");
                }
            });
        });

        $("button[id=check_coupon_code]").on('click', function () {

            let code = $("input[name=coupon_code]").val();

            if ( code.length <= 0 || code.length < 3 ){
                $("input[name=coupon_code]").addClass('is-invalid');
                $("#coupon_error_description").text("");
                $("#coupon_error_description").text("كود الخصم لابد ان يكون ٣ احرف او أكثر").removeClass('valid-feedback').addClass('invalid-feedback');
            }else{

                if ( $("input[name=coupon_code]").has('is-invalid') ){
                    $("input[name=coupon_code]").removeClass('is-invalid');
                    $("#coupon_error_description").text("");
                }

                let course = $("input[name=course]").val();

                $.ajax({
                    url: "http://127.0.0.1:8000/api/v-1/coupon/course="+course+"&coupon="+code,
                    type: "get",
                    success: function (data, result) {
                        if ( data['status'] == "Success" ){
                            $("#coupon_error_description").text(data['response']).removeClass('invalid-feedback').addClass('valid-feedback');
                        }else{
                            $("#coupon_error_description").text(data['response']).removeClass('valid-feedback').addClass('invalid-feedback');
                        }
                    },
                    error: function () {
                        alert("هناك خطأ الرجاء المحاولة لاحقا");
                    }
                });

            }
        });

    </script>
@endsection


@section('content')
    <div class="container mb-5">
        <div class="row justify-content-center mt-lg-2">
            <div class="col-lg-10">

                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="alert alert-warning rounded">
                            <div class="row">
                                <div class="col-lg-2 order-last">
                                    <div class="text-center timer">
                                        <h1 class="p-0 m-0" id="counter">10:00</h1>
                                    </div>
                                </div>
                                <div class="col-lg-10 text-right">
                                    <p class="m-0" id="counter" style="padding-top: 13px;"> سوف يتم اعادة توجيهك للصفحة السابقة في حال انتهى
                                        الموقت ولم تقم بإنهاء الحجز</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">

                    <div class="col-lg-6 order-last">

                        <div class="ticket-information">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <h4 class="text-right">معلومات التذكرة</h4>
                                    <input type="hidden" name="center" value="{{ $course[0]->center->user_id }}">
                                    <input type="hidden" name="course" value="{{ $course[0]->identifier }}">
                                </div>
                            </div>

                            <div class="block rounded mt-0 mb-4">
                                <div class="row justify-content-end">
                                    <div class="col-lg-12 text-right">
                                        <?php $total_amount = 0; ?>
                                        @foreach($appointments as $appointment)
                                            <?php $total_amount += (int)$appointment->price; ?>
                                            @if( date('a', strtotime($appointment->time)) == 'pm' )
                                                <p class="mb-0 mt-0"> {{ date('h:i', strtotime($appointment->time)) }}
                                                    - {{ date('F d l', strtotime($appointment->date)) }}</p>
                                            @else
                                                <p class="mb-0 mt-0"> {{ date('h:i', strtotime($appointment->time)) }}
                                                    - {{ date('F d l', strtotime($appointment->date)) }}</p>
                                            @endif

                                            <p class="text-danger mt-0 mb-0"><b> تنذكرة حضور</b></p>
                                            <p class="mt-0 mb-0 text-muted rtl"><b>{{ $appointment->price }} ريال</b></p>
                                            @if($appointment->gender == 1)
                                                <p class="rtl mt-1 mb-0">( تذكرة رجال فوق عمر 16 ) العدد ١</p>
                                            @else
                                                <p class="rtl mt-1 mb-0">( تذكرة نساء فوق عمر 16 ) العدد ١</p>
                                            @endif
                                            <hr>
                                        @endforeach

                                        <p class="text-danger rtl mb-0">الاجمالي : {{ $total_amount }} ريال </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rule-information mt-4">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <h4 class="text-right">ملاحظات مهمة</h4>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    <div class="block rounded mt-0 pb-1">
                                        <div class="row justify-content-end">
                                            <div class="col-lg-12 text-right">
                                                <ul class="rtl text-right"
                                                    style="list-style-type: none; margin-right: 0; width: 100%; padding-right: 0px;">
                                                    <li>
                                                        <span class="fas fa-arrow-alt-circle-left text-custom"></span>
                                                        <span>16 سنة أو أكبر</span>
                                                    </li>

                                                    <li>
                                                        <span class="fas fa-arrow-alt-circle-left text-custom"></span>
                                                        <span>التذكرة صالحة لشخص واحد فقط</span>
                                                    </li>

                                                    <li>
                                                        <span class="fas fa-arrow-alt-circle-left text-custom"></span>
                                                        <span>فضلاً أحضر معك تذكرتك الإلكترونية لتسهيل إجراءات الدخول يوم الفعالية.</span>
                                                    </li>

                                                    <li>
                                                        <span class="fas fa-arrow-alt-circle-left text-custom"></span>
                                                        <span>لن يتم إصدار التذكرة الإ بعد الدفع</span>
                                                    </li>

                                                    <li>
                                                        <span class="fas fa-arrow-alt-circle-left text-custom"></span>
                                                        <span>ممنوع اصطحاب الأطفال</span>
                                                    </li>

                                                    <li>
                                                        <span class="fas fa-arrow-alt-circle-left text-custom"></span>
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

                    <div class="col-lg-6">

                        <div class="coupon-section">
                            <div class="row">
                                <div class="col-12 text-right">
                                    <h4 class="text-right">أكواد الخصم</h4>
                                </div>
                            </div>

                            <div class="block rounded mt-0">
                                <div class="row justify-content-end">
                                    <div class="col-lg-12 text-right">
                                        <p class="m-0">كود الخصم</p>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-9 order-last">
                                        <input type="text" class="form-control text-center" name="coupon_code"
                                               placeholder="كود الخصم">
                                            <div class="invalid-feedback text-center d-block" id="coupon_error_description">
                                            </div>
                                    </div>

                                    <div class="col-lg-3 text-right">
                                        <button class="btn btn-block btn-success" id="check_coupon_code">التحقق</button>
                                    </div>

                                </div>

                                <div class="row mt-2">
                                    <div class="col-lg-9 offset-3 text-center">
                                        {{--<p class="m-0">result</p>--}}
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="payment-section mt-4 mb-2">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h4 class="text-right">طريقة الدفع</h4>
                                </div>
                            </div>

                            <div class="block mt-0 rounded">

                                <div class="bank-selection">
                                    <select class="custom-select {{ $errors->has('bank') ? ' is-invalid' : '' }} custom-input" name="bank" required>
                                        <option>- البنك -</option>
                                        @foreach($banks as $bank)
                                            @if($bank->id  == $course[0]->center->account[0]->bank->id)
                                                <option value="{{ $bank->id }}" selected>{{ $bank->name }}</option>
                                            @else
                                                <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="bank-information mt-4">

                                    <div class="account-information">

                                        <div class="row justify-content-center">
                                            <div class="col-lg-8">
                                                <img src="{{ $course[0]->center->account[0]->bank->logo }}" class="d-block ml-auto" alt="Bank Logo" style="width: 100%;">
                                            </div>
                                        </div>

                                        <div class="row justify-content-center mt-4">
                                            <div class="col-lg-8 text-right">
                                                <p class="mb-0 rtl"> البنك : {{ $course[0]->center->account[0]->bank->name }} </p>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center mt-0">
                                            <div class="col-lg-8 text-right">
                                                <p class="m-0 rtl"> اسم الحساب : {{ $course[0]->center->account[0]->account_owner }} </p>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center mt-0">
                                            <div class="col-lg-8 text-right">
                                                <p class="m-0 rtl">  رقم الحساب : {{ $course[0]->center->account[0]->account_number }} </p>
                                            </div>
                                        </div>

                                        <div class="row justify-content-center mt-0">
                                            <div class="col-lg-8 text-right">
                                                <p class="m-0 rtl">  رقم الايبان : {{ $course[0]->center->account[0]->account_number }} </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="submit-section mt-0 mb-2">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button class="btn btn-block custom-btn">احجز التذكرة</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection