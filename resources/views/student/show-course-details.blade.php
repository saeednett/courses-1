@extends('student.master-v-1-1')

@section('title', $course->title)

@section('guest-links')
    <a class="dropdown-item" href="{{ route('account.login') }}">تسجيل الدخول</a>
    <a class="dropdown-item" href="{{ route('account.register') }}">تسجيل مستخدم جديد</a>
@endsection

@section('style-file')

@endsection

@section('script-file')
    <script>
        $('.carousel').carousel();
    </script>
@endsection


@section('content')

    <div class="container mb-5">
        <div class="row justify-content-center mt-lg-3 mt-2">
            <div class="col-lg-10">
                <?php $students = array(); ?>
                @foreach($course->appointment->reservation as $reservation)
                    @if($reservation->student_id == \Illuminate\Support\Facades\Auth::user()->student->id)
                        <? array_push($students, $reservation->student_id); ?>
                    @endif
                @endforeach
                @if(!empty($students))
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="alert alert-success">
                                <ul class="text-right mb-0 rtl">
                                    <li>لقد قم بالتسجيل في هذه الدورة</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-12 col-sm-12 col-12 text-right order-lg-last order-first mb-lg-4 mt-lg-0 mb-0 mt-4">
                        <h3>{{ $course->title }}</h3>
                        <div class="main-info">
                            <div class="course-logo rounded-top" style="height: 300px; width: 100%; overflow: hidden">
                                <img src="/storage/course-images/{{ $course->image[0]->url }}" alt=""
                                     style="width: 100%; height: 100%; display: block; margin: auto;">
                            </div>
                            <div class="block rounded-bottom mt-0">
                                <div class="row">
                                    <div class="col-lg-9 col-md-8 col-sm-8 col-8">
                                        <h5 class="text-right d-lg-block d-none rtl"><span>اسم المنظم:</span> <a
                                                    href="{{ route('center.profile', $course->center->user->username) }}">{{ $course->center->user->name }}</a>
                                        </h5>
                                        <h5 class="text-right d-lg-none d-block rtl"><a
                                                    href="{{ route('center.profile', $course->center->user->username) }}">{{ $course->center->user->name }}</a>
                                        </h5>
                                        <div class="mt-4"
                                             style="position: absolute; bottom: 0; width: 92%; height: 40px; margin: auto; overflow: hidden;">
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
                                    <div class="col-lg-3 col-md-4 col-sm-4 col-4">
                                        <div class="logo-holder"
                                             style="width: 90px; height: 90px; overflow: hidden; padding: 0;">
                                            <img class="border"
                                                 src="/storage/center-images/{{ $course->center->logo }}"
                                                 alt=""
                                                 style="width: 100%; height: 100%; display: block; margin: auto; padding: 3px;">
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
                                        {{ $course->title }}
                                    </div>
                                </div>

                                <div class="row info">
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-4 text-right order-last rtl">
                                        <i class="fa fa-calendar-o labels-icon"></i>
                                        <span class="">التاريخ:</span>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-8 col-8 rtl">
                                        {{ date('F d l', strtotime($course->appointment->start_date)) }}
                                    </div>
                                </div>

                                <div class="row info">
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-4 text-right order-last rtl">
                                        <i class="fa fa-map-marker labels-icon"></i>
                                        <span class="">المدينة:</span>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-8 col-8 rtl">
                                        {{ $course->city->name}}
                                    </div>
                                </div>

                                <div class="row info">
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-4 text-right order-last rtl">
                                        <i class="fa fa-map-marker labels-icon"></i>
                                        <span class="">العنوان:</span>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-8 col-8 rtl">
                                        {{ $course->address }}
                                    </div>
                                </div>

                                <div class="row info">
                                    <div class="col-lg-3 col-md-3 col-sm-4 col-4 text-right rtl order-last">
                                        <i class="fa fa-clock-o labels-icon"></i>
                                        <span class="">الوقت:</span>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-8 col-8 rtl">
                                        @if( date('a', strtotime($course->appointment->start_time)) == 'pm' )
                                            {{ date('h:i', strtotime($course->appointment->start_time)).' مساء' }}
                                        @else
                                            {{ date('h:i', strtotime($course->appointment->start_time)).' صباحا' }}
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
                                        $date1 = date_create($course->appointment->start_date);
                                        $date2 = date_create($course->appointment->finish_date);
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


                            <div class="block rounded mb-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="text-right">
                                            {{ $course->title }}
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class=""
                                           style="text-align: right; overflow-wrap: break-word;">{{ $course->description }}</p>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                        <div class="row justify-content-center mt-lg-0 mt-4">
                            <div class="col-12">
                                <h4 class="text-right pr-2">ملاحظات مهمة</h4>
                            </div>

                            <div class="col-12">
                                <div class="block rounded mt-0">
                                    <div class="row">
                                        <div class="col-lg-12">
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
                                                    <span>الحضور قبل موعد الفعالية بنصف ساعة على الأقل</span>
                                                </li>

                                                <li>
                                                    <span class="fas fa-arrow-alt-circle-left text-custom"></span>
                                                    <span>فضلاً أحضر معك تذكرتك الإلكترونية لتسهيل إجراءات الدخول يوم الفعالية.</span>
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
                                            <p class="text-center mb-1">تأكد من الاطلاع على سياسة الاسترجاع</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mt-4">
                            <div class="col-12">
                                <h4 class="text-right pr-2">خريطة الموقع</h4>
                            </div>

                            <div class="col-12">
                                <div class="map-location">
                                    <div class="map rounded-top" style="height: 250px; width: 100%; overflow: hidden">
                                        <img src="https://snazzy-maps-cdn.azureedge.net/assets/1243-xxxxxxxxxxx.png?v=20170626083204"
                                             style="width: 100%; height: 100%; display: block; margin: auto;">
                                    </div>
                                    <div class="block rounded-bottom mt-0 rtl">
                                        <p class="text-right">{{ $course->city->name.' - '.$course->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row justify-content-lg-end justify-content-center">
                    <div class="col-lg-7 col-12">
                        <?php $students = array(); ?>
                        @foreach($course->appointment->reservation as $reservation)
                            @if($reservation->student_id == \Illuminate\Support\Facades\Auth::user()->student->id)
                                <?php array_push($students, $reservation->student_id); ?>
                            @endif
                        @endforeach
                        @if(empty($students))
                            <form method="post" action="{{ route('account.course.booking', $course->identifier) }}">
                                {{ csrf_field() }}
                                <button type="submit" class="btn custom-btn">احجز الآن</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection