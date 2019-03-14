@extends('student.master-v-1-1')

@section('title', 'خطأ')

@section('guest-links')
    <a class="dropdown-item" href="{{ route('account.login') }}">تسجيل الدخول</a>
    <a class="dropdown-item" href="{{ route('account.register') }}">تسجيل مستخدم جديد</a>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/student/courses-index.css') }}"/>
@endsection

@section('script-file')
    <script>
        $('.carousel').carousel();
    </script>
    <script src="{{ asset('js/student/courses-index.js') }}"></script>
@endsection



@section('content')

    <div class="container">
        <div class="row justify-content-center mt-lg-3 mt-2">
            <div class="col-lg-10 col-md-12 col-sm-12 col-12">

                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-10 pr-0">
                        <div class="alert alert-danger text-right">
                            <ul class="mb-0 text-right rtl">
                                <li class="text-danger">{{ $error }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mb-4">
                    <div class="">
                        <div class="col-6">
                            <img src="{{ asset('img/student/error-404.png')  }}">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection