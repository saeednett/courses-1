@extends('student.master-v-1-1')

@section('title', 'تذاكري')

@section('content')
    <div class="wrap">
        <div class="container">
            <div class="row justify-content-center mt-3">
                <div class="col-lg-10 col-md-12 col-sm-12 col-12">
                    <div class="row justify-content-end">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                            <div class="row justify-content-center">
                                <div class="col-lg-12 col-md-12 col-sm-10 col-10">
                                    <h1 class="text-lg-right text-md-right text-center d-lg-block d-md-block d-none">
                                        تذاكري</h1>
                                    <h3 class="text-right d-lg-none d-md-none d-block">
                                        تذاكري</h3>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-2">
                                <div class="col-10 text-center d-lg-none d-md-none d-sm-block d-block">
                                    <select class="custom-select" name="filter-type"
                                            onchange="alert($('select[name=filter-type]').val())">
                                        <optgroup label="تصنيف العرض">
                                            <option value="1" selected>الجميع</option>
                                            <option value="2">المنتهية</option>
                                            <option value="3">المؤكدة</option>
                                            <option value="4">المعلقة</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-12 text-right d-lg-block d-md-block d-none rtl">
                                    <button class="btn filter-tabs custom-active">الجميع</button>
                                    <button class="btn filter-tabs">المنتهية</button>
                                    <button class="btn filter-tabs">المؤكدة</button>
                                    <button class="btn filter-tabs">المعلقة</button>
                                </div>
                            </div>

                            @if(session()->has('success'))
                                <div class="row mt-4">
                                    <div class="col-lg-12 col-md-12 col-10">
                                        <div class="alert alert-success">
                                            <ul class="text-right mb-0 rtl">
                                                <li>{{ session('success') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="row mt-4">
                                    <div class="col-lg-12 col-md-12 col-10">
                                        <div class="alert alert-danger">
                                            <ul class="text-right mb-0 rtl">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="row justify-content-lg-end justify-content-md-end justify-content-sm-center justify-content-center mb-4">
                                @foreach($reservations as $reservation)
                                    <div class="col-lg-4 col-md-5 col-sm-8 col-10 mt-3">
                                        <div class="card"
                                             style="border-radius: 0; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                                            <img src="/storage/course-images/{{ $reservation->appointment->course->image[0]->url }}"
                                                 class="card-img-top" alt="..." width="301" height="200">
                                            <div class="card-title text-center mt-2 mr-2">
                                                <h5 title="اسم الدورة">{{ $reservation->appointment->course->title }}</h5>
                                                <h5 class="text-muted"
                                                    title="تاريخ الدورة">{{ $reservation->appointment->start_date }}</h5>
                                            </div>
                                            <div class="adv-footer">

                                                @if($reservation->appointment->course->appointment->price == 0)
                                                    <p class="adv-price">مجانًا</p>
                                                @else
                                                    <p class="adv-price">{{ $reservation->appointment->course->appointment->price }}</p>
                                                @endif
                                                <p class="adv-place">{{ $reservation->appointment->course->city->name }}</p>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        {{-- If The User Has Confirmed His Payment Fir The Course --}}
                                        @if(!is_null($reservation->payment))
                                            {{-- If The Date Of The Course Is Equal Or Greater Than Today's Date  --}}
                                            @if($reservation->appointment->start_date >= date('y-m-d'))
                                                @if($reservation->appointment->start_date > date('y-m-d') && $reservation->confirmation == 1)
                                                    <div class="status">
                                                        <div class="col-12 bg-warning"
                                                             style="padding-top: 10px; padding-bottom: 5px;">
                                                            <p class="text-center mb-0"><b>عرض بطاقة الحضور</b></p>
                                                        </div>
                                                    </div>

                                                    <div class="status">
                                                        <div class="col-12 bg-success"
                                                             style="padding-top: 8px;border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
                                                            <p class="text-white text-center mb-0"><b>مؤكدة</b></p>
                                                        </div>
                                                    </div>
                                                @elseif($reservation->appointment->start_date > date('y-m-d') && $reservation->confirmation == 0)
                                                    <div class="status">
                                                        <div class="col-12 p-0 m-0">
                                                            <a href="{{ route('student.payment.confirmation.edit', $reservation->identifier) }}">
                                                                <button class="btn btn-block rtl"
                                                                        style="border: none; border-radius: 0; background: #00bdac;">
                                                                    <b>تعديل معلومات تأكيد الدفع</b>
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="status">
                                                        <div class="col-12 bg-warning"
                                                             style="padding-top: 8px;border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
                                                            <p class="text-white text-center mb-0"><b>بنتظار التأكد من
                                                                    الدفع</b></p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="status">
                                                    <div class="col-12 bg-danger"
                                                         style="padding-top: 8px;border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
                                                        <p class="text-white text-center mb-0"><b>الدورة منتهية</b></p>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="status">
                                                <div class="col-12 p-0 m-0">
                                                    <a href="{{ route('student.payment.confirmation', $reservation->identifier) }}">
                                                        <button class="btn btn-block rtl"
                                                                style="border: none; border-radius: 0; background: #00bdac;">
                                                            <b>ابلاغ بدفع ({{ $reservation->appointment->price }}
                                                                ريال)</b>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="status">
                                                <div class="col-12 bg-danger"
                                                     style="padding-top: 8px;border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
                                                    <p class="text-white text-center mb-0"><b>بنتظار الدفع</b></p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection