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
        if ( min == 0 && sec == 0 ){
            alert("yes");
        }

        let countdown = setInterval(function() {
            if ( min == 0 && sec == 0 ){
                $('#counter').text(min+":"+sec);
                clearInterval(countdown);
                history.back();
            }else{
                if ( sec == 0 ){
                    min --;
                    sec = 59;
                }else{
                    sec--;
                }
            }
            $('#counter').text(min+":"+sec);
        }, 1000);
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
                                <div class="col-lg-3 order-last">
                                    <div class="timer" style="padding: 10px; background: rebeccapurple; text-align: center;">
                                        <h1 class="p-0 m-0" id="counter">10:00</h1>
                                    </div>
                                </div>
                                <div class="col-lg-9" style="padding: 25px 0 0 0; background: saddlebrown; text-align: center;">
                                    <p class="p-0 m-0" id="counter"> سوف يتم اعادة توجيهك للصفحة السابقة في حال انتهى الموقت ولم تقم بإنهاء الحجز</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">

                    <div class="col-lg-6 bg-danger order-last">
                        <div class="row">
                            <div class="col-12 text-right">
                                <h4 class="text-right">معلومات التذكرة</h4>
                            </div>
                        </div>

                        <div class="block rounded mt-0">

                        </div>
                    </div>

                    <div class="col-lg-6 bg-secondary">
                        <div class="row">
                            <div class="col-12 text-right">
                                <h4 class="text-right">أكواد الخصم</h4>
                            </div>
                        </div>

                        <div class="block rounded mt-0">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection