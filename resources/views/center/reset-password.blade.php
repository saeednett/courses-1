@extends('center.layouts.master-v-1-1')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/reset-password.css') }}" />
@endsection

@section('content')
    @if(session()->has('success'))
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 animatedParent animateOnce z-index-50">
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
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">إعادة تعيين كلمة المرور</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="container-fluid">
                            <form method="post" action="{{ route('center.reset.password.confirm') }}">
                                {{ csrf_field() }}
                                <div class="row form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="old_password" class="col-form-label required-field">كلمة المرور القديمة</label>
                                        <input type="password" id="old_password"
                                               class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }} custom-input text-center"
                                               name="old_password"
                                               placeholder="كلمة المرور القديمة" autocomplete="off" required>
                                        @if ($errors->has('old_password'))
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('old_password') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="password" class="col-form-label required-field"> كلمة المرور الجديدة</label>
                                        <input type="password" id="password"
                                               class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }} custom-input text-center"
                                               name="password"
                                               placeholder="كلمة المرور الجديدة" autocomplete="off" required>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="password_confirmation" class="col-form-label required-field">تأكيد
                                            كلمة المرور الجديدة</label>
                                        <input type="password" id="password_confirmation"
                                               class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }} custom-input text-center"
                                               name="password_confirmation" placeholder="تأكيد كلمة المرور الجديدة"
                                               autocomplete="off" required>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="row form-group mt-20">
                                    <div class="col-lg-4 col-lg-offset-4">
                                        <button class="btn btn-block custom-btn">حفظ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection