@extends('admin.layouts.course-preview-master')

@section('title', $course->title)

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/student/show-course-details.css') }}" />
@endsection

@section('script-file')
    <script>
        $('.carousel').carousel();

        $('.preview').on('click', function () {
            $("#warning-model").modal("show");
        });
    </script>
@endsection


@section('content')

    <div class="container mb-5">

        <div class="row">
            <div class="modal fade" id="warning-model" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-danger close" data-dismiss="modal">تنبيه!</h4>
                        </div>
                        <div class="modal-body text-right">
                            <p class="text-danger">هذه الصفحة للمعاينة فقط لرؤية المزيد انتقل للموقع كطالب</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-lg-3 mt-2">
            <div class="col-lg-10">
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-12 col-sm-12 col-12 text-right order-lg-last order-first mb-lg-4 mt-lg-0 mb-0 mt-4">
                        <h3>{{ $course->title }}</h3>
                        <div class="main-info">
                            <div class="course-logo rounded-top">
                                <img src="/storage/course-images/{{ $course->image[0]->image }}" alt="{{ $course->title }}">
                            </div>
                            <div class="block rounded-bottom mt-0">
                                <div class="row">
                                    <div class="col-lg-9 col-md-8 col-sm-8 col-8">
                                        <h5 class="text-right d-lg-block d-none rtl"><span>اسم المنظم:</span> <a class="preview"
                                                    href="#">{{ $course->center->user->name }}</a>
                                        </h5>
                                        <h5 class="text-right d-lg-none d-block rtl"><a class="preview"
                                                    href="#">{{ $course->center->user->name }}</a>
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
                                    <div class="col-lg-3 col-md-4 col-sm-4 col-4">
                                        <div class="logo-holder">
                                            <img class="border"
                                                 src="/storage/center-images/{{ $course->center->logo }}"
                                                 alt="{{ $course->center->user->name }}">
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
                                        {{ date('F d l', strtotime($course->start_date)) }}
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
                                        @if( date('a', strtotime($course->start_time)) == 'pm' )
                                            {{ date('h:i', strtotime($course->start_time)).' مساء' }}
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
                                        <p class="course-description">{{ $course->description }}</p>
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
                                            <ul class="custom-rules text-right rtl">
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
                                    <div class="map rounded-top">
                                        <img src="https://snazzy-maps-cdn.azureedge.net/assets/1243-xxxxxxxxxxx.png?v=20170626083204">
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

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection