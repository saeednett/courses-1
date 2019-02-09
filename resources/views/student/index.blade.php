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
    </script>
@endsection



@section('content')
    <div class="container">
        <div class="row justify-content-center mt-lg-3 mt-2">
            <div class="col-lg-10">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 order-lg-first order-last d-lg-block d-md-block d-none text-lg-right text-center">
                        <a href="http://lammt.com/pricing" target="_self" title="">
                            <img src="{{ asset('img/student/adv.png') }}" alt="create your event"
                                 title="create your event">
                        </a>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-12 p-0">
                        <div class="banner" style="min-height: 339px; width: 100%; overflow: hidden;">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="{{ asset('img/student/Yaser_Presents-02.png') }}" class="" alt="..."
                                             style="width: 100%; height: 330px;">
                                        <div class="carousel-caption d-block d-md-block"
                                             style="width: 100%; background: #000000a6; bottom: 0; left: 0; right: 0; padding-top: 10px; padding-bottom: 0;">
                                            <h5>Hello</h5>
                                            <p>jniowejvioenvoiejm</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('img/student/330x640@3x-.jpg') }}" class="" alt="..."
                                             style="width: 100%; height: 330px;">
                                        <div class="carousel-caption d-block d-md-block"
                                             style="width: 100%; background: #000000a6; bottom: 0; left: 0; right: 0; padding-top: 10px; padding-bottom: 0;">
                                            <h5>Hello</h5>
                                            <p>jniowejvioenvoiejm</p>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <img src="{{ asset('img/student/Dmam_Lammat_2-01.png') }}" class="" alt="..."
                                             style="width: 100%; height: 330px;">
                                        <div class="carousel-caption d-block d-md-block"
                                             style="width: 100%; background: #000000a6; bottom: 0; left: 0; right: 0; padding-top: 10px; padding-bottom: 0;">
                                            <h5>Hello</h5>
                                            <p>jniowejvioenvoiejm</p>
                                        </div>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                   data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                   data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12 text-lg-right text-center mt-4">
                        <h1>آخر الفعاليات</h1>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-12 col-12 rtl text-lg-right text-center d-lg-block d-md-block d-none">
                        <button class="btn filter-tabs custom-active">الجميع</button>
                        <button class="btn filter-tabs">فعالية مدفوعة</button>
                        <button class="btn filter-tabs">فعالية مجانية</button>
                        <button class="btn filter-tabs">فعالية متاحة</button>
                    </div>

                    <div class="col-lg-12 col-11 rtl text-lg-right text-center d-lg-none d-md-none d-block">
                        <div class="form-group">
                            <select class="custom-select" name="filter-type" onchange="alert($('select[name=filter-type]').val())">
                                <optgroup label="تصفية البحث">
                                    <option value="1" selected>الجميع</option>
                                    <option value="2">فعالية مدفوعة</option>
                                    <option value="3">فعالية مجانية</option>
                                    <option value="4">فعالية متاحة</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row justify-content-center mt-2 mb-4">
            <div class="col-lg-10 col-md-10 col-sm-10 col-11">
                <div class="row">

                    @if( count($courses) > 0 )

                        @foreach($courses as $course)
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mt-3">
                                <a class="card" href="{{ route('account.course_details', [$course->center->user->username, $course->identifier,] ) }}"
                                   title="{{ $course->title }}">
                                    <img src="/storage/course-images/{{ $course->image[0]->url }}" class="card-img-top" alt="..." width="301" height="200">
                                    <div class="card-title text-center mt-2 mr-2">
                                        <h5>{{ $course->title }}</h5>
                                    </div>
                                    <div class="adv-footer">
                                        @if( count($course->appointment) > 1)
                                            @if($course->appointment[0]->price == 0)
                                                <p class="adv-price">مجانًا</p>
                                            @else
                                                <p class="adv-price">{{ $course->appointment[0]->price }}</p>
                                            @endif
                                        @else
                                            @foreach($course->appointment as $appointment)
                                                @if($appointment->price == 0)
                                                    <p class="adv-price">مجانًا</p>
                                                @else
                                                    <p class="adv-price">{{ $appointment->price }}</p>
                                                @endif
                                            @endforeach
                                        @endif
                                        <p class="adv-place">{{ $course->city->name }}</p>
                                    </div>
                                    <div class="clear"></div>
                                </a>
                            </div>
                        @endforeach

                    @else
                        <div class="col-12 mt-4">
                            <h2 class="text-right text-danger">لاتوجد دورات حالية</h2>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection