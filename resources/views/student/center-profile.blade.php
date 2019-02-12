@extends('student.master-v-1-1')

@section('title', $center->name)

@section('content')
    <div class="wrap text-md-center ">
        <div class="profile-wall h-lg-40 h-md-30 h-sm-30 h-25">
            <img src="/storage/center-images/{{ $center->center->cover }}">
        </div>


        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="row justify-content-center">

                        <div class="col-lg-3 col-md-4 profile-info rtl order-lg-last order-md-last order-sm-last order-first">

                            <div class="profile-avatar">
                                <img src="/storage/center-images/{{ $center->center->logo }}">
                            </div>

                            <div class="profile-title text-right">{{ $center->name }}</div>
                            <div class="profile-site text-right"><a href="http://www.youtube.com/user/JedComedyClub" target="_blank"><b>{{ $center->center->website }}</b></a></div>
                            <div class="profile-description rtl text-right">
                                {{ $center->center->about }}
                            </div>

                            <div class="profile-social-media-accounts">
                                <ul class="nav profile-social-media p-0" >
                                    <li>
                                        <a class="social social-twitter" href=href="http://twitter.com/breakoutksa" style="background-image: url('https://lammt.com/resource/img/icon_tw.png'); background-size: 100%;"></a>
                                    </li>
                                    <li>
                                        <a class="social social-twitter" href=href="http://twitter.com/breakoutksa" style="background-image: url('https://lammt.com/resource/img/icon_fb.png'); background-size: 100%;"></a>
                                    </li>
                                    <li>
                                        <a class="social social-twitter" href=href="http://twitter.com/breakoutksa" style="background-image: url('https://lammt.com/resource/img/icon_snap.png'); background-size: 100%;"></a>
                                    </li>
                                    <li>
                                        <a class="social social-twitter" href=href="http://twitter.com/breakoutksa" style="background-image: url('https://lammt.com/resource/img/icon_instagram.png'); background-size: 100%;"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        <div class="col-lg-9 col-md-8 order-first profile-content-wraper">
                            <div class="row">
                                <div class="col-md-12 rtl text-lg-right text-center d-lg-block d-md-block d-none">
                                    <button class="btn filter-tabs custom-active">الدورات الحالية ( {{ count($current_appointment) }} )</button>
                                    <button class="btn filter-tabs">الدورات السابقة ( {{ count($past_appointment) }} )</button>
                                </div>
                            </div>

                            <div class="row justify-content-end mt-4">
                                <div class="col-lg-12 col-md-12 mt-2 text-center">
                                    <div class="row justify-content-end">
                                        @foreach($courses as $course)
                                            <div class="col-lg-4 col-md-6">
                                                <a class="card rounded" data-post="1452" href="{{ route('account.course_details', [$course->center->user->username, $course->identifier,] ) }}"
                                                   title="#بسطة_ماركت4">
                                                    <img src="/storage/course-images/{{ $course->image[0]->url }}" class="" alt="..." height="200" width="100%"
                                                         style="width: 100%">
                                                    <div class="card-title text-center mt-4">
                                                        <h5>{{ $course->title }}</h5>
                                                    </div>
                                                    <div class="adv-footer">
                                                        <p class="adv-price">{{ $course->appointment[0]->price }}</p>
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