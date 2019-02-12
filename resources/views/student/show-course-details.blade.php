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
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 order-last text-right mb-4">
                        <h2>{{ $course->title }}</h2>
                        <div class="main-info">
                            <div class="course-logo rounded-top" style="height: 300px; width: 100%; overflow: hidden">
                                <img src="/storage/course-images/{{ $course->image[0]->url }}" alt=""
                                     style="width: 100%; height: 100%; display: block; margin: auto;">
                            </div>
                            <div class="block rounded-bottom mt-0">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <h5 class="text-right rtl"><span>اسم المنظم:</span> <a
                                                    href="{{ route('center.profile', $course->center->user->username) }}">{{ $course->center->user->name }}</a></h5>
                                        <div class="mt-4"
                                             style="position: absolute; bottom: 0; width: 92%; height: 40px; margin: auto; overflow: hidden;">
                                            <div class="row justify-content-end">
                                                <div class="col-lg-8 text-center h-100">
                                                    <div class="row justify-content-center">
                                                        <div class="col-lg mt-1">
                                                            <i class="fab fa-facebook fa-2x"></i>
                                                        </div>

                                                        <div class="col-lg mt-1">
                                                            <i class="fab fa-twitter fa-2x"></i>
                                                        </div>

                                                        <div class="col-lg mt-1">
                                                            <i class="fab fa-snapchat fa-2x"></i>
                                                        </div>

                                                        <div class="col-lg mt-1">
                                                            <i class="fab fa-instagram fa-2x"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="logo-holder" style="width: 90px; height: 90px; overflow: hidden; padding: 0;">
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
                                    <div class="col-lg-3 text-right rtl order-last">
                                        <i class="fa fa-star labels-icon"></i>
                                        <span class="">الدورة:</span>
                                    </div>
                                    <div class="col-lg-9">
                                        {{ $course->title }}
                                    </div>
                                </div>

                                <div class="row info">
                                    <div class="col-lg-3 text-right rtl order-last">
                                        <i class="fa fa-calendar-o labels-icon"></i>
                                        <span class="">التاريخ:</span>
                                    </div>
                                    <div class="col-lg-9">
                                        {{ date('F d l', strtotime($course->appointment[0]->date)) }}
                                    </div>
                                </div>

                                <div class="row info">
                                    <div class="col-lg-3 text-right rtl order-last">
                                        <i class="fa fa-map-marker labels-icon"></i>
                                        <span class="">المكان:</span>
                                    </div>
                                    <div class="col-lg-9 rtl">
                                        {{ $course->city->name.' - '.$course->address }}
                                    </div>
                                </div>

                                <div class="row info">
                                    <div class="col-lg-3 text-right rtl order-last">
                                        <i class="fa fa-clock-o labels-icon"></i>
                                        <span class="">الوقت:</span>
                                    </div>
                                    <div class="col-lg-9 rtl">
                                        @if( date('a', strtotime($course->appointment[0]->time)) == 'pm' )
                                            {{ date('h:i', strtotime($course->appointment[0]->time)).' مساء' }}
                                        @else
                                            {{ date('h:i', strtotime($course->appointment[0]->time)).' صباحا' }}
                                        @endif
                                    </div>
                                </div>

                            </div>


                            <div class="block rounded mb-4">
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

                    <div class="col-lg-5">
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="text-right">التذاكر</h2>
                            </div>
                        </div>


                        @if($errors->any())
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="alert alert-danger">
                                        <ul class="text-right rtl mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="block rounded mt-0">
                                    <div class="row">

                                        <div class="col-lg-7 text-right mt-3">
                                            {{ date('F d l', strtotime($course->appointment[0]->date)) }}
                                        </div>

                                        <div class="col-lg-2 text-right mt-3">
                                            <span class="center-block">التاريخ:</span>
                                        </div>

                                        <div class="col-lg-3">
                                            <i class="fa fa-calendar fa-3x text-custom"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="block rounded">
                            <form method="post" action="{{ route('account.course.booking', $course->identifier) }}" id='book-course'>
                                {{ csrf_field() }}
                                <?php $counter = 1; $class = "mt-4";?>

                                    @foreach($course->appointment as $appointment)
                                        @if( $counter == 1 )
                                            <?php $class = "mt-0";?>
                                        @else
                                            <?php $class = "mt-4";?>
                                        @endif
                                        <div class="row justify-content-end {{ $class }}">
                                            <div class="col-lg-10">
                                                @if( date('a', strtotime($appointment->time)) == 'pm' )
                                                    <p class="text-right rtl mt-1 mb-0">{{ date('h:i', strtotime($appointment->time)).' مساء' }}</p>
                                                    @if($appointment->gender == 1)
                                                        <p class="text-right rtl mt-1 mb-0">( تذكرة رجال فوق عمر 16 )</p>
                                                    @else
                                                        <p class="text-right rtl mt-1 mb-0">( تذكرة نساء فوق عمر 16 )</p>
                                                    @endif

                                                    <p class="text-right text-muted rtl mt-1 mb-0">
                                                        <b>{{ $appointment->price }} ريال </b></p>
                                                @else
                                                    <p class="text-right rtl mt-1 mb-0">{{ date('h:i', strtotime($appointment->time)).' صباحا' }}</p>
                                                    @if($appointment->gender == 1)
                                                        <p class="text-right rtl mt-1 mb-0">( تذكرة رجال فوق عمر 16 )</p>
                                                    @else
                                                        <p class="text-right rtl mt-1 mb-0">( تذكرة نساء فوق عمر 16 )</p>
                                                    @endif
                                                    <p class="text-right text-muted rtl mt-1 mb-0">
                                                        <b>{{ $appointment->price }} ريال </b></p>
                                                @endif
                                            </div>
                                            <div class="col-lg-2 order-first {{ $errors->has('date') ? 'bg-danger rounded' : '' }}">
                                                <label class="checkbox-container">
                                                    <input type="checkbox" name="date[]" value="{{ $appointment->id }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                @if ($errors->has('date'))
                                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('date[0]') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($counter < count($course->appointment))
                                            <hr>
                                        @endif
                                        <?php $counter++; ?>
                                    @endforeach

                            </form>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn custom-btn" form="book-course">احجز الآن</button>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <h2 class="text-right">ملاحظات مهمة</h2>
                            </div>

                            <div class="col-lg-12">
                                <div class="block rounded">
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
                            <div class="col-lg-12">
                                <h2 class="text-right">خريطة الموقع</h2>
                            </div>
                            <div class="col-lg-12">
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
            </div>
        </div>
    </div>
@endsection