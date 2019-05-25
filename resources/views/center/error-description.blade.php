@extends('center.layouts.master-v-1-1')

@section('title', "خطأ")

@section('style-file')

@endsection

@section('content')
    <div class="row">
        @if($errors->any())
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
                        <li>{{ $errors->first('error') }}</li>
                    </ul>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
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
                                <div class="row">
                                    <div class="col-lg-8 col-lg-offset-2">
                                        <h3 class="text-center text-danger pt-8">{{ $errors->first('error') }}</h3>
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