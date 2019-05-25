@extends('student.layouts.master-v-1-1')

@section('title', 'الدورات')

@section('guest-links')
    <a class="dropdown-item" href="{{ route('account.login') }}">تسجيل الدخول</a>
    <a class="dropdown-item" href="{{ route('account.register') }}">تسجيل مستخدم جديد</a>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/student/index.css') }}"/>
@endsection

@section('content')

    <div class="container">

        <div class="row justify-content-center mt-lg-3 mt-2">
            <div class="col-lg-10 col-md-12 col-sm-12 col-12">

                @if($errors->any())
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-10 pr-0 pl-0">
                            <div class="alert alert-danger text-right rtl">
                                <ul class="mb-0 text-danger text-right">
                                    <li>{{ $errors->first() }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session()->has('success'))
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-10 pr-0 pl-0">
                            <div class="alert alert-success text-right rtl">
                                <ul class="mb-0 text-right">
                                    <li>{{ session('success') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-12 p-0">
                        @if($banners_state == 1)
                            <div class="banner">
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php $counter = 1; ?>

                                        @foreach($banners as $banner)
                                            @if($counter == 1)
                                                @if($banner->status == 1)
                                                    <div class="carousel-item active">
                                                        <a href="{{ $banner->link }}"> <img
                                                                    src="storage/banner-images/{{ $banner->banner }}"
                                                                    class="banner-img"
                                                                    alt="image"> </a>
                                                        <div class="carousel-caption d-block d-md-block">
                                                            <h5>{{ $banner->title }}</h5>
                                                            <p>{{ $banner->description }}</p>
                                                        </div>
                                                    </div>
                                                    <?php $counter++; ?>
                                                @endif
                                            @else
                                                @if($banner->status == 1)
                                                    <div class="carousel-item">
                                                        <a href="{{ $banner->link }}"> <img
                                                                    src="storage/banner-images/{{ $banner->banner }}"
                                                                    class="banner-img"
                                                                    alt="image"> </a>
                                                        <div class="carousel-caption d-block d-md-block">
                                                            <h5>{{ $banner->title }}</h5>
                                                            <p>{{ $banner->description }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach


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
                        @endif
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 p-0 order-first">

                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-10 text-right mt-4 pr-0">
                        <h1>احدث الدورات</h1>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12 rtl text-lg-right text-center d-lg-block d-md-block d-none pr-0">
                        <input type="hidden" name="token" value="{{ csrf_token() }}">
                        <button class="btn filter-tabs custom-active" data-filter="all">الجميع</button>
                        <button class="btn filter-tabs" data-filter="payed">دورات مدفوعة</button>
                        <button class="btn filter-tabs" data-filter="free">دورات مجانية</button>
                        <button class="btn filter-tabs" data-filter="available">دورات متاحة</button>
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
                </div>

            </div>
        </div>


        <div class="row justify-content-center mt-2 mb-4">
            <div class="col-lg-10 col-md-10 col-sm-10 col-10 pr-0">
                <div class="row justify-content-end pb-3" id="viewHolder">

                    @if( count($courses) > 0 )

                        @foreach($courses as $course)
                            <div class="col-lg-4 col-md-4 col-sm-4 col-12 mt-3">
                                <a class="card"
                                   href="{{ route('account.course_details', [$course->center->user->username, $course->identifier,] ) }}"
                                   title="{{ $course->title }}">
                                    <img src="/storage/course-images/{{ $course->image->image }}"
                                         class="card-img-top"
                                         alt="..." width="301" height="200">
                                    <div class="card-title text-center mt-2 mr-2">
                                        <h5>{{ $course->title }}</h5>
                                    </div>
                                    <div class="adv-footer">
                                        @if($course->type == 'free')
                                            <p class="adv-price">مجانًا</p>
                                        @else
                                            <p class="adv-price rtl">{{ $course->price }} ريال</p>
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

@section('script-file')
    <script src="{{ asset('js/student/index.js') }}"></script>
@endsection