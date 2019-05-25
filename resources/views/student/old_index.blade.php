@extends('student.layouts.master')

@section('title', 'الفعالبات')

@section('style-file-1')

@endsection

@section('style-file-2')

@endsection

{{--@section('style-file-3')--}}
{{--@endsection--}}

@section('script-file-1')
    <script>
        $('.carousel').carousel();
    </script>
@endsection

{{--@section('script-file-2')--}}
{{--@endsection--}}

{{--@section('script-file-3')--}}
{{--@endsection--}}



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-offset-1 col-lg-7 col-md-12 col-sm-12 col-xs-12" style="margin-top: 10px;">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="{{ asset('img/Yaser_Presents-02.png') }}" alt="Chania"
                                 style="width: 100%; height: 331px;">
                        </div>

                        <div class="item">
                            <img src="{{ asset('img/Dmam_Lammat_2-01.png') }}" alt="Chicago"
                                 style="width: 100% ; height: 331px;">
                        </div>

                        <div class="item">
                            <img src="{{ asset('img/330x640@3x-.jpg') }}" alt="New York"
                                 style="width: 100% ; height: 331px;">
                        </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12 text-right" style="margin-top: 10px;">
                <a href="http://lammt.com/pricing" target="_self" title="">
                    <img src="{{ asset('img/adv.png') }}" alt="create your event"
                         title="create your event">
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-offset-1 col-lg-10">
                <h1>آخر الفعاليات</h1>
                <ul class="nav nav-tabs front-tabs">
                    <li class="active"><a href="https://lammt.com/#category-all" title="الجميع">الجميع</a></li>
                    <li><a href="https://lammt.com/#category-44" title="فعالية مدفوعة">فعالية مدفوعة</a></li>
                    <li><a href="https://lammt.com/#category-43" title="فعالية مجانية">فعالية مجانية</a></li>
                    <li><a href="https://lammt.com/#category-43" title="فعالية مجانية">فعالية متاحة</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-offset-1 col-lg-10">
                <div class="row">

                    <div class="col-lg-4">
                        <a class="single-activity" data-post="1452" href="https://lammt.com/JeddahChamber/BM4"
                           title="#بسطة_ماركت4">
                            <img width="301" height="200"
                                 src="{{ asset('img/031.jpg ') }}"
                                 alt="#بسطة_ماركت4" title="#بسطة_ماركت4">
                            <div class="sa-about">
                                <div class="sa-title">
                                    #بسطة_ماركت4
                                </div>
                                <div class="sa-data">
                                    <p class="sa-ticket-left">
                                    </p>
                                    <p class="sa-ticket-price">
                                        مجانًا </p>
                                    <p class="sa-ticket-price">
                                        جدة </p>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4">
                        <a class="single-activity" data-post="1452" href="https://lammt.com/JeddahChamber/BM4"
                           title="#بسطة_ماركت4">
                            <img width="301" height="200"
                                 src="{{ asset('img/031.jpg ') }}"
                                 alt="#بسطة_ماركت4" title="#بسطة_ماركت4">
                            <div class="sa-about">
                                <div class="sa-title">
                                    #بسطة_ماركت4
                                </div>
                                <div class="sa-data">
                                    <p class="sa-ticket-left">
                                    </p>
                                    <p class="sa-ticket-price">
                                        مجانًا </p>
                                    <p class="sa-ticket-price">
                                        جدة </p>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4">
                        <a class="single-activity" data-post="1452" href="https://lammt.com/JeddahChamber/BM4"
                           title="#بسطة_ماركت4">
                            <img width="301" height="200"
                                 src="{{ asset('img/031.jpg ') }}"
                                 alt="#بسطة_ماركت4" title="#بسطة_ماركت4">
                            <div class="sa-about">
                                <div class="sa-title">
                                    #بسطة_ماركت4
                                </div>
                                <div class="sa-data">
                                    <p class="sa-ticket-left">
                                    </p>
                                    <p class="sa-ticket-price">
                                        مجانًا </p>
                                    <p class="sa-ticket-price">
                                        جدة </p>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>


    </div>
@endsection