@extends('student.layouts.master-v-1-1')

@section('title', 'تعديل معلومات الدغع')

@section('guest-links')
    <a class="dropdown-item" href="{{ route('account.login') }}">تسجيل الدخول</a>
    <a class="dropdown-item" href="{{ route('account.register') }}">تسجيل مستخدم جديد</a>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/student/edit-payment-confirmation.css') }}" />
@endsection

@section('content')

    <div class="container mb-5">
        <div class="row justify-content-center mt-lg-3 mt-2">
            <div class="col-lg-10 col-12">
                @if(session()->has('success'))
                    <div class="row mt-4">
                        <div class="col-12">
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
                        <div class="col-12">
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
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 text-right order-lg-last order-md-first order-sm-first order-first mb-lg-4 mt-lg-0 mt-4">
                        <div class="row justify-content-center">
                            <div class="course-information-section col-12">
                                <div class="row">

                                    <div class="col-12">
                                        <h4>{{ $reservation->course->title }}</h4>
                                    </div>

                                    <div class="col-12">
                                        <div class="main-info">
                                            <div class="course-logo rounded-top">
                                                <img src="/storage/course-images/{{ $reservation->course->image->image }}"
                                                     alt="$reservation->course->title">
                                            </div>
                                            <div class="block rounded-bottom mt-0">
                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9 col-sm-9 col-9">
                                                        <h5 class="text-right d-lg-block d-none rtl">
                                                            <span>اسم المنظم:</span> <a
                                                                    href="{{ route('center.profile', $reservation->course->center->user->username) }}">{{ $reservation->course->center->user->name }}</a>
                                                        </h5>
                                                        <h5 class="text-right d-lg-none d-block rtl"><a
                                                                    href="{{ route('center.profile', $reservation->course->center->user->username) }}">{{ $reservation->course->center->user->name }}</a>
                                                        </h5>
                                                        <div class="social-media mt-4">
                                                            <div class="row justify-content-end">
                                                                <div class="col-lg-8 text-center h-100">
                                                                    <div class="row justify-content-center">
                                                                        <div class="col-lg col-md col-sm col mt-1">
                                                                            <i class="fa fa-facebook fa-2x"></i>
                                                                        </div>

                                                                        <div class="col-lg col-md col-sm col mt-1">
                                                                            <i class="fa fa-twitter fa-2x"></i>
                                                                        </div>

                                                                        <div class="col-lg col-md col-sm col mt-1">
                                                                            <i class="fa fa-snapchat fa-2x"></i>
                                                                        </div>

                                                                        <div class="col-lg col-md col-sm col mt-1">
                                                                            <i class="fa fa-instagram fa-2x"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 col-3 p-0">
                                                        <div class="logo-holder">
                                                            <img class="border col-10"
                                                                 src="/storage/center-images/{{ $reservation->course->center->logo }}"
                                                                 alt="{{ $reservation->course->center->user->name }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="block rounded">

                                                <div class="row info">
                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-4 text-right order-last rtl">
                                                        <i class="fa fa-star labels-icon"></i>
                                                        <span class="">الدورة:</span>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-8 col-8 rtl">
                                                        {{ $reservation->course->title }}
                                                    </div>
                                                </div>

                                                <div class="row info">
                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-4 text-right order-last rtl">
                                                        <i class="fa fa-calendar-o labels-icon"></i>
                                                        <span class="">التاريخ:</span>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-8 col-8 rtl">
                                                        {{ date('F d l', strtotime($reservation->course->start_date)) }}
                                                    </div>
                                                </div>

                                                <div class="row info">
                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-4 text-right order-last rtl">
                                                        <i class="fa fa-map-marker labels-icon"></i>
                                                        <span class="">المدينة:</span>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-8 col-8 rtl">
                                                        {{ $reservation->course->city->name}}
                                                    </div>
                                                </div>

                                                <div class="row info">
                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-4 text-right order-last rtl">
                                                        <i class="fa fa-map-marker labels-icon"></i>
                                                        <span class="">العنوان:</span>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-8 col-8 rtl">
                                                        {{ $reservation->course->address }}
                                                    </div>
                                                </div>

                                                <div class="row info">
                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-4 text-right rtl order-last">
                                                        <i class="fa fa-clock-o labels-icon"></i>
                                                        <span class="">الوقت:</span>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-8 col-8 rtl">
                                                        @if( date('a', strtotime($reservation->course->start_time)) == 'pm' )
                                                            {{ date('h:i', strtotime($reservation->course->start_time)).' مساء' }}
                                                        @else
                                                            {{ date('h:i', strtotime($course->start_time)).' صباحا' }}
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row info">
                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-4 text-right rtl order-last">
                                                        <i class="fa fa-calendar labels-icon"></i>
                                                        <span class="">المدة:</span>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-8 col-8 rtl">
                                                        <?php
                                                        $date1 = date_create($reservation->course->start_date);
                                                        $date2 = date_create($reservation->course->end_date);
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

                                            </div>


                                            <div class="block rounded mb-4">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <p class="text-right">
                                                            {{ $reservation->course->title }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <p class="course-description">{{ $reservation->course->description }}</p>
                                                        <hr>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <div class="row justify-content-center">

                            <div class="payment-information-section col-12 order-lg-first order-last mt-lg-0 mt-4">
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <h4 class="text-right pr-2">معلومات الدفع</h4>
                                    </div>
                                    <div class="col-12">
                                        <div class="block rounded pt-0 mt-0">
                                            <form method="post"
                                                  action="{{ route('student.payment.confirmation.update', $reservation->identifier) }}"
                                                  enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="PUT">
                                                <div class="form-group row mt-2">
                                                    <div class="col-lg-12 text-right">
                                                        <label class="col-form-label required-field rtl"
                                                               for="account_owner">اسم
                                                            صاحب الحساب</label>
                                                        <input type="text" id="account_owner"
                                                               class="form-control {{ $errors->has('account_owner') ? ' is-invalid' : '' }} text-center"
                                                               name="account_owner"
                                                               value="{{ $reservation->payment->account_owner }}"
                                                               placeholder="اسم صاحب الحساب" autocomplete="off"
                                                               maxlength="50"
                                                               minlength="10" required>
                                                        @if ($errors->has('account_owner'))
                                                            <span class="invalid-feedback text-center" role="alert">
                                                       <strong>{{ $errors->first('account_owner') }}</strong>
                                                   </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row mt-2">
                                                    <div class="col-lg-12 text-right">
                                                        <label class="col-form-label required-field rtl"
                                                               for="account_number">رقم
                                                            الحساب</label>
                                                        <input type="text" id="account_number"
                                                               class="form-control {{ $errors->has('account_number') ? ' is-invalid' : '' }}  num-only text-center"
                                                               name="account_number"
                                                               value="{{ $reservation->payment->account_number }}"
                                                               placeholder="رقم الحساب" autocomplete="off"
                                                               maxlength="30"
                                                               minlength="10" required>
                                                        @if ($errors->has('account_number'))
                                                            <span class="invalid-feedback text-center" role="alert">
                                                       <strong>{{ $errors->first('account_number') }}</strong>
                                                   </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row mt-2 mb-0">
                                                    <div class="col-lg-12 text-right">
                                                        <label class="col-form-label required-field rtl"
                                                               for="receipt-image">صورة
                                                            الإيصال بالتحويل</label>
                                                        <input type="text" id="receipt-image"
                                                               class="form-control {{ $errors->has('receipt-image') ? ' is-invalid' : '' }} text-center"
                                                               placeholder="صورة الإيصال الخاص بالتحويل"
                                                               autocomplete="off"
                                                               readonly>
                                                        @if ($errors->has('receipt-image'))
                                                            <span class="invalid-feedback text-center" role="alert">
                                                       <strong>{{ $errors->first('receipt-image') }}</strong>
                                                   </span>
                                                        @endif
                                                        <input type="file" class="receipt-image" name="receipt-image"
                                                               accept="image/png, image/jpg">
                                                    </div>
                                                </div>

                                                <div class="form-group row mt-0">
                                                    <div class="col-lg-12">
                                                        <button class="btn btn-block custom-btn mt-0">تأكييد الدفع
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="notes-section col-12 order-lg-last order-first">
                                <div class="row mt-lg-4 mt-0">
                                    <div class="col-12">
                                        <h4 class="text-right pr-2">ملاحظات مهمة</h4>
                                    </div>

                                    <div class="col-12">
                                        <div class="block rounded">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <ul class="custom-rules text-right rtl">
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
                                                            <span>الحضور قبل موعد الفعالية بنصف ساعة على الأقل</span>
                                                        </li>

                                                        <li>
                                                            <span class="fa fa-arrow-circle-o-left text-custom"></span>
                                                            <span>فضلاً أحضر معك تذكرتك الإلكترونية لتسهيل إجراءات الدخول يوم الفعالية.</span>
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
                                                    <p class="text-center mb-1">تأكد من الاطلاع على سياسة الاسترجاع</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="map-section col-12 order-lg-last">
                                <div class="row mt-4">
                                    <div class="col-lg-12">
                                        <h4 class="text-right pr-2">خريطة الموقع</h4>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="map-location">
                                            <div class="map rounded-top">
                                                <img src="https://snazzy-maps-cdn.azureedge.net/assets/1243-xxxxxxxxxxx.png?v=20170626083204">
                                            </div>
                                            <div class="block rounded-bottom mt-0 rtl">
                                                <p class="text-right">{{ $reservation->course->city->name.' - '.$reservation->course->address }}</p>
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
    </div>
@endsection

@section('script-file')
    <script src="{{ asset('js/student/edit-payment-confirmation.js') }}"></script>
@endsection