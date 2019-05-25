@extends('student.layouts.master-v-1-1')

@section('title', 'تذاكري')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/student/tickets.css') }}"/>
@endsection

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

                            <div class="row justify-content-end">
                                <div class="col-12 text-right d-lg-block d-md-block d-none rtl">
                                    <input type="hidden" name="token" value="{{ csrf_token() }}">
                                    <button class="btn filter-tabs custom-active" data-filter="all">الجميع</button>
                                    <button class="btn filter-tabs" data-filter="finished">المنتهية</button>
                                    <button class="btn filter-tabs" data-filter="confirmed">المؤكدة</button>
                                    <button class="btn filter-tabs" data-filter="unconfirmed">المعلقة</button>
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

                            <div class="row justify-content-lg-end justify-content-md-end justify-content-sm-center justify-content-center mb-4"
                                 id="viewHolder">
                                @foreach($reservations as $reservation)
                                    <div class="col-lg-4 col-md-5 col-sm-8 col-10 mt-3">

                                        @if($reservation->confirmation == 0)

                                            <?php $class = "no-border"; ?>
                                            <div class="status">
                                                <div class="col-12 cancel-reservation bg-danger">
                                                    <a href="{{ route('student.reservation.destroy', $reservation->identifier) }}">
                                                        <button class="btn btn-block rtl">
                                                            <p class="text-white text-center mb-0"><b>إلغاء الحجز</b></p>
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>

                                        @else
                                            <?php $class = ""; ?>
                                        @endif

                                        <div class="card">
                                            <img src="/storage/course-images/{{ $reservation->course->image->image }}"
                                                 class="card-img-top {{ $class }}" alt="..." width="301"
                                                 height="200">


                                            <div class="card-title text-center mt-2 mr-2">
                                                <h5 title="اسم الدورة">{{ $reservation->course->title }}</h5>
                                                <h5 class="text-muted"
                                                    title="تاريخ الدورة">{{ $reservation->start_date }}</h5>
                                            </div>
                                            <div class="adv-footer">
                                                @if($reservation->course->price == 0)
                                                    <p class="adv-price">مجانًا</p>
                                                @else
                                                    <p class="adv-price">{{ $reservation->course->price }}</p>
                                                @endif
                                                <p class="adv-place">{{ $reservation->course->city->name }}</p>
                                            </div>
                                            <div class="clear"></div>
                                        </div>

                                        {{-- If The User Has Confirmed His Payment Fir The Course --}}
                                        @if(!is_null($reservation->payment))
                                            {{-- If The Date Of The Course Is Equal Or Greater Than Today's Date  --}}
                                            @if($reservation->course->start_date >= date('y-m-d'))
                                                @if($reservation->course->start_date > date('y-m-d') && $reservation->confirmation == 1)
                                                    <div class="status">
                                                        <div class="col-12 show-confirmed-ticket bg-success">
                                                            <a href="{{ route('account.course.ticket.show', $reservation->identifier) }}">
                                                                <button class="btn btn-block rtl">
                                                                    <p class="text-center mb-0"><b>عرض بطاقة الحضور</b></p>
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="status border-top">
                                                        <div class="col-12 confirmed-ticket-label bg-success">
                                                            <p class="text-white text-center mb-0"><b>مؤكدة</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                @elseif($reservation->course->start_date > date('y-m-d') && $reservation->confirmation == 0)
                                                    <div class="status">
                                                        <div class="col-12 p-0 m-0">
                                                            <a href="{{ route('student.payment.confirmation.edit', $reservation->identifier) }}">
                                                                <button class="btn btn-block edit-ticket rtl">
                                                                    <b>تعديل معلومات تأكيد الدفع</b>
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="status">
                                                        <div class="col-12 unconfirmed-ticket bg-warning">
                                                            <p class="text-white text-center mb-0"><b>بنتظار
                                                                    التأكد من
                                                                    الدفع</b></p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="status">
                                                    <div class="col-12 finish-ticket bg-danger">
                                                        <p class="text-white text-center mb-0"><b>الدورة
                                                                منتهية</b></p>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            @if($reservation->course->type == "payed")
                                                <div class="status">
                                                    <div class="col-12 p-0 m-0">
                                                        <a href="{{ route('student.payment.confirmation', $reservation->identifier) }}">
                                                            <button class="btn btn-block payed-ticket rtl">
                                                                <b>ابلاغ بدفع ({{ $reservation->course->price }}
                                                                    ريال)</b>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="status">
                                                    <div class="col-12 waiting-paying bg-danger">
                                                        <p class="text-white text-center mb-0"><b>بنتظار
                                                                الدفع</b></p>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="status">
                                                    <div class="col-12 unconfirmed-ticket bg-warning">
                                                        <p class="text-white text-center mb-0"><b>بنتظار تأكيد
                                                                التذكرة</b></p>
                                                    </div>
                                                </div>
                                            @endif
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

@section('script-file')
    <script src="{{ asset('js/student/tickets.js') }}"></script>
@endsection