@extends('center.master-v-1-1')

@section('title', "خطأ")

{{--@section('page-links')--}}
    {{--<li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-users"></i>المسؤولين</a></li>--}}
    {{--<li class="active"><a href="{{ route('center.trainer.create') }}"><i class="fa fa-user-plus"></i>إضافة مسؤول</a></li>--}}
{{--@endsection--}}

@section('style-file')

@endsection

@section('content')
    <style>
        .required-field:after {
            color: #ff6771;
            content: " *";
            text-align: right;
        }

        .rtl {
            direction: rtl;
        }

        .ltr {
            direction: ltr;
        }

        select {
            direction: rtl;
            text-align: center !important;
            text-align-last: center !important;
        }

        .custom-input {
            height: 50px;
            border-radius: 30px;
            border: 1px solid rgba(34, 36, 38, .15);
        }

        .custom-input:hover {
            border: 2px solid #1bc3a1;
        }

        .custom-input:focus {
            box-shadow: none !important;
            border: 2px solid #1bc3a1;
        }

        .custom-btn {
            height: 60px;
            border-radius: 30px;
            background-image: linear-gradient(to right, #1bc3a1 0%, #6fcf8f);
            display: block;
            border: none;
            font-size: 18px;
            color: #fff;
        }

        .custom-btn:hover {
            box-shadow: 0 4px 10px 0 rgba(11, 121, 99, 0.31);
        }

        .select2-container--default .select2-selection--single {
            height: 50px !important;
            border-radius: 30px !important;
        }

        .select2-selection__arrow{
            height: 100% !important;
        }
        .select2-selection__rendered{
            margin-top: 6px;
            width: 100%;
            height: 100%;
            text-align: center;
        }
        .invalid-feedback{
            color: #ab1717;
            width: 100%;
            display: block;
            direction: rtl;
            text-align: center;
        }
        .is-invalid{
            border-color: #ab1717;
        }
    </style>
    <div class="row">
        @if($errors->any())
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right rtl" style="margin-bottom: 0;">
                        <li>{{ $errors->first('error') }}</li>
                    </ul>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="text-right rtl" style="margin-bottom: 0;">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        @endif

        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">

                <div class="panel-heading clearfix">

                    <h3 class="panel-title">{{ $errors->first('title') }}</h3>
                </div>

                <div class="panel-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="">
                                <div class="row">
                                    <div class="col-lg-4 col-lg-offset-4">
                                        <img src="http://n1.vpn4vpn.com/new-vpn/open-iphone-help/warning-flat-icon-150x150.png" class="center-block mr-auto ml-auto">
                                    </div>
                                </div>
                                <div class="row" style="">
                                    <div class="col-lg-8 col-lg-offset-2">
                                        <h3 class="text-center text-danger" style="padding-top: 8px;">{{ $errors->first('error') }}</h3>
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

@endsection