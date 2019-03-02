@extends('student.master-v-1-1')

@section('title', $center->name)

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/student/center-profile.css') }}"/>
@endsection

@section('content')
    <div class="wrap text-md-center ">
        <div class="profile-wall h-lg-40 h-md-50 h-sm-30 h-25">
            <img src="/storage/center-images/{{ $center->center->logo }}">
        </div>
        <div class="container mb-4">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-4 col-sm-12 col-12 profile-info mb-lg-4 rtl order-lg-last order-md-last order-sm-first order-first">
                            <div class="profile-avatar">
                                <img src="/storage/center-images/{{ $center->center->logo }}">
                            </div>
                            <div class="profile-title text-right">{{ $center->name }}</div>
                            <div class="profile-site text-right"><a href="http://www.youtube.com/user/JedComedyClub"
                                                                    target="_blank"><b>{{ $center->center->website }}</b></a>
                            </div>
                            <div class="profile-description rtl text-right">
                                {{ $center->center->about }}
                            </div>
                            <div class="profile-social-media-accounts">
                                <ul class="nav profile-social-media p-0">
                                    <li>
                                        <a class="social social-twitter" href=href="http://twitter.com/breakoutksa"></a>
                                    </li>
                                    <li>
                                        <a class="social social-facebook"
                                           href=href="http://twitter.com/breakoutksa"></a>
                                    </li>
                                    <li>
                                        <a class="social social-snapchat"
                                           href=href="http://twitter.com/breakoutksa"></a>
                                    </li>
                                    <li>
                                        <a class="social social-instagram"
                                           href=href="http://twitter.com/breakoutksa"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-12 col-12 order-lg-first order-md-first profile-content-wraper">
                            <div class="row justify-content-end">
                                <div class="col-md-12 rtl text-lg-right text-right d-lg-block d-md-block d-none">
                                    <button class="btn filter-tabs custom-active">الدورات الحالية
                                        ( {{ count($courses) }} )
                                    </button>
                                    <button class="btn filter-tabs">الدورات السابقة ( {{ count($courses) }} )</button>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-4">
                                <div class="col-lg-12 col-md-12 col-sm-6 col-9 mt-2 text-center">
                                    <div class="row justify-content-end">
                                        @foreach($courses as $course)
                                            <div class="col-lg-4 col-md-6">
                                                <a class="card rounded" data-post="1452"
                                                   href="{{ route('account.course_details', [$course->center->user->username, $course->identifier,] ) }}"
                                                   title="#بسطة_ماركت4">
                                                    <img src="/storage/course-images/{{ $course->image[0]->image }}"
                                                         class="w-100" alt="{{ $course->title }}" height="200">
                                                    <div class="card-title text-center mt-4">
                                                        <h5>{{ $course->title }}</h5>
                                                    </div>
                                                    <div class="adv-footer">
                                                        @if($course->type == 'free')
                                                            <p class="adv-price">مجانا</p>
                                                        @else
                                                            <p class="adv-price">{{ $course->price }}</p>
                                                        @endif
                                                        <p class="adv-place">{{ $course->city->name }}</p>
                                                    </div>
                                                    <div class="clear"></div>
                                                </a>
                                            </div>
                                        @endforeach
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