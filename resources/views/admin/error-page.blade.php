@extends('admin.layouts.master-statistics')

@section('content')
    <!-- Main content -->
    <style>
        .warning-color {
            color: #fff466;
        }
    </style>


    @if($errors->any())
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="mb-0 text-right text-danger rtl">
                        <li>{{ $errors->first('message') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">{{ $errors->first('error_title') }}</h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-4 col-lg-offset-4">
                            <img class="" style="width: 60%; height: 200px; display: block; margin: auto; padding: 10px;" src="https://www.freeiconspng.com/uploads/error-icon-4.png" alt="">
                        </div>

                        <div class="col-lg-6 col-lg-offset-3">
                            <div class="alert alert-danger animated fadeInUp">
                                <ul class="mb-0 text-center text-danger rtl">
                                    <li>
                                        <h3 class="mb-0" style="margin-bottom: 0;">{{ $errors->first('message') }}</h3>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /main content -->
@endsection