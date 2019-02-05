@extends('student.master-v-1-1')

@section('title', 'تذاكري')

@section('content')
    <div class="wrap">
        <div class="container">
            <div class="row justify-content-center mt-3">

                <div class="col-lg-4 order-lg-first order-last mt-lg-5 mt-4 mb-4 align-self-start sticky-top">
                    <div class="block rounded text-right">
                        <p class="rtl">فريق خدمة العملاء جاهز دائماً للمساعدة.</p>
                        <p class="rtl"> اتصل بنا: <b>0592970476</b> </p>
                        <p class="rtl"> او راسلنا: <b>soao_d@hotmail.com</b></p>
                    </div>
                </div>

                <div class="col-lg-6 col-12">

                    <h1 class="text-lg-right text-md-right text-center d-lg-block d-md-block d-none">تذاكري</h1>
                    <h3 class="text-lg-right text-md-right text-center d-lg-none d-md-none d-block">تذاكري</h3>

                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-12 rtl mt-2 text-lg-right text-center d-lg-none d-md-none d-block">
                            <div class="form-group">
                                <select class="custom-select" name="filter-type" onchange="alert($('select[name=filter-type]').val())">
                                    <optgroup label="تصنيف العرض">
                                        <option value="1" selected>الجميع</option>
                                        <option value="2">الحالية</option>
                                        <option value="3">المنتهية</option>
                                        <option value="4">المؤكدة</option>
                                        <option value="5">المعلقة</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>

                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            <ul class="text-right mb-0 rtl">
                                <li>{{ session('success') }}</li>
                            </ul>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="text-right mb-0 rtl">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="booked-tickets rounded mt-lg-3 mt-1">
                        <div class="row justify-content-center">

                            <div class="col-lg-2 col-md-2 col-sm-4 col-12 text-center p-2 order-lg-last order-md-last order-first">
                                <img src="https://lammt.com/resource/img/booking-status-waiting.png" class="ticket-icon img-thumbnail mt-lg-2 mt-md-2 mt-0" style="width: 40px; height: 40px; margin-top: 12px;">
                            </div>

                            <div class="col-lg-5 col-md-5 col-sm-5 col-12">
                                <div class="text-lg-right text-md-right text-center">
                                    <p class="mb-0 text-muted">19 يناير 2019</p>
                                </div>
                                <div class="text-lg-right text-md-right text-center">
                                    <p class="mb-0">الصيدلي الخارق</p>
                                </div>
                                <div class="text-lg-right text-md-right text-center">
                                    <p class="mt-1 mb-0 rtl"> <i class="fa fa-ticket"></i> <span class="rtl">1</span> <span class="rtl">التذاكر المحجوزة</span> </p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-8 order-lg-first order-md-first order-last rtl text-center mt-2">
                                <div class="mt-lg-4">
                                    <span class="payment-verfiy btn-block rounded">ابلاغ بدفع (١٠٠ ريال)</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="booked-tickets rounded mt-lg-3 mt-4">
                        <div class="row justify-content-center">

                            <div class="col-lg-2 col-md-2 col-sm-4 col-12 text-center p-2 order-lg-last order-md-last order-first">
                                <img src="https://lammt.com/resource/img/booking-status-invalid.png" class="ticket-icon img-thumbnail mt-lg-2 mt-md-2 mt-0" style="width: 40px; height: 40px; margin-top: 12px;">
                            </div>

                            <div class="col-lg-5 col-md-5 col-sm-5 col-12">
                                <div class="text-lg-right text-md-right text-center">
                                    <p class="mb-0 text-muted">19 يناير 2019</p>
                                </div>
                                <div class="text-lg-right text-md-right text-center">
                                    <p class="mb-0">الصيدلي الخارق</p>
                                </div>
                                <div class="text-lg-right text-md-right text-center">
                                    <p class="mt-1 mb-0 rtl"> <i class="fa fa-ticket"></i> <span class="rtl">1</span> <span class="rtl">التذاكر المحجوزة</span> </p>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-4 col-8 order-lg-first order-md-first order-last rtl text-center mt-2">
                                <div class="mt-lg-4">
                                    <span class="payment-verfiy btn-block rounded">ابلاغ بدفع (١٠٠ ريال)</span>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection