@extends('admin.layouts.master')

@section('main-title', " تعديل كلمة المرور")

@section('page-links')
    <li><a href="{{ route('center.index', Auth::user()->username) }}"><i class="fa fa-users"></i>اللف الشخصي</a></li>
    <li class="active"><a href="{{ route('admin.reset.password') }}"><i class="fa fa-user-plus"></i>كلمة المرور</a>
    </li>
@endsection

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/admin/reset-password.css') }}"/>
@endsection

@section('content')
    @if($errors->any())
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="text-right mb-0 rtl">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="block animated fadeInUp">
                <h4>لحفظ بياناتك ننصحك باختيار رقم سري صعب التوقع ونقترح عليك مايلي...</h4>
                <ol>
                    <li>على الأقل مكون من 6 خانات وكلما زاد العدد كلما كان أصعب</li>
                    <li>يحتوي على حروف كبيرة وصغيرة باللغة الإنجليزية</li>
                    <li>يحتوي على أرقام ورموز لايمكن توقعها</li>
                    <li>لايعتمد على معلومة من معلوماتك الشخصية</li>
                    <li>لايعتمد على كلمة في القاموس لسهولة توقعها</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row mt-20">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">

                <div class="panel-heading clearfix">
                    <h3 class="panel-title">إعادة تعيين كلمة المرور</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                        <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                    </ul>
                </div>

                <div class="panel-body">

                    <form method="post" action="{{ route('admin.reset.password.confirm') }}"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}


                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field" for="old_password">كلمة المرور القديمة</label>
                                    <input type="password"
                                           class="form-control {{ $errors->has('old_password') ? ' is-invalid' : '' }} custom-input text-center"
                                           name="old_password" id="old_password" placeholder="كلمة المرور القديمة"
                                           minlength="8"
                                           maxlength="32" autocomplete="off" required>
                                    @if ($errors->has('old_password'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field" for="password">كلمة المرور</label>
                                    <input type="password"
                                           class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }} custom-input text-center"
                                           name="password" id="password" placeholder="كلمة المرور الجديدة" minlength="6"
                                           maxlength="32" autocomplete="off" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label class="required-field" for="password_confirmation">تأكيد كلمة المرور</label>
                                    <input type="password"
                                           class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }} custom-input text-center"
                                           name="password_confirmation" id="password_confirmation"
                                           placeholder="تأكيد كلمة المرور الجديدة" minlength="8" maxlength="32"
                                           autocomplete="off" required>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row mt-20">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-block custom-btn">حفظ</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-file')
    <script src="{{ asset('js/admin/reset-password.js') }}"></script>
    <script src="{{ asset('js/center/plugins/select2/select2.full.min.js') }}"></script>
@endsection