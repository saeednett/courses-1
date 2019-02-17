@extends('student.master-v-1-1')

@section('title', 'الدورات')

@section('guest-links')
    <a class="dropdown-item" href="{{ route('account.login') }}">تسجيل الدخول</a>
    <a class="dropdown-item" href="{{ route('account.register') }}">تسجيل مستخدم جديد</a>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/student/courses-index.css') }}" />
@endsection

@section('script-file')
    <script>
        $('.carousel').carousel();
    </script>
@endsection



@section('content')
    <div class="container">
        <div class="row justify-content-center mt-lg-3 mt-2">
            <div class="col-lg-10 col-md-12 col-sm-12 col-12">

                @if(session()->has('success'))
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-10 pr-0">
                            <div class="alert alert-success text-right">
                                <ul class="mb-0 text-right">
                                    <li>{{ session('success') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0 d-none">
                        @if(count($courses) > 0)
                            <div class="banner">
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="/storage/course-images/{{ $courses[0]->image[0]->url }}" class="banner-img"
                                                 alt="{{ $courses[0]->title }}">
                                            <div class="carousel-caption d-block d-md-block">
                                                <h5>{{ $courses[0]->title }}</h5>
                                                <p>{{ $courses[0]->appointment->start_date }}</p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img src="/storage/course-images/{{ $courses[0]->image[0]->url }}" class="banner-img"
                                                 alt="{{ $courses[0]->title }}">
                                            <div class="carousel-caption d-block d-md-block">
                                                <h5>{{ $courses[0]->title }}</h5>
                                                <p>{{ $courses[0]->appointment->date }}</p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <img src="/storage/course-images/{{ $courses[0]->image[0]->url }}" class=""
                                                 alt="{{ $courses[0]->title }}"
                                                 >
                                            <div class="carousel-caption d-block d-md-block">
                                                <h5>{{ $courses[0]->title }}</h5>
                                                <p>{{ $courses[0]->appointment->date }}</p>
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
                        @endif
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-10 text-right mt-4">
                        <h1>احدث الدورات</h1>
                    </div>
                </div>

                <div class="row justify-content-center">
                    @if(count($courses) > 0)
                        <div class="col-12 rtl text-lg-right text-center d-lg-block d-md-block d-none">
                            <button class="btn filter-tabs custom-active">الجميع</button>
                            <button class="btn filter-tabs">دورات مدفوعة</button>
                            <button class="btn filter-tabs">دورات مجانية</button>
                            <button class="btn filter-tabs">دورات متاحة</button>
                        </div>

                        <div class="col-10 rtl text-center d-lg-none d-md-none d-block">
                            <select class="custom-select" name="filter-type"
                                    onchange="alert($('select[name=filter-type]').val())">
                                <optgroup label="تصفية البحث">
                                    <option value="1" selected>الجميع</option>
                                    <option value="2">دورات مدفوعة</option>
                                    <option value="3">دورات مجانية</option>
                                    <option value="4">دورات متاحة</option>
                                </optgroup>
                            </select>
                        </div>
                    @endif
                </div>

            </div>
        </div>


        <div class="row justify-content-center mt-2 mb-4">
            <div class="col-lg-10 col-md-10 col-sm-10 col-10">
                <div class="row justify-content-end">
                    @if( count($courses) > 0 )

                        @foreach($courses as $course)
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mt-3">
                                <a class="card"
                                   href="{{ route('account.course_details', [$course->center->user->username, $course->identifier,] ) }}"
                                   title="{{ $course->title }}">
                                    <img src="/storage/course-images/{{ $course->image[0]->url }}" class="card-img-top"
                                         alt="..." width="301" height="200">
                                    <div class="card-title text-center mt-2 mr-2">
                                        <h5>{{ $course->title }}</h5>
                                    </div>
                                    <div class="adv-footer">
                                        @if($course->appointment->price == 0)
                                            <p class="adv-price">مجانًا</p>
                                        @else
                                            <p class="adv-price rtl">{{ $course->appointment->price }} ريال</p>
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