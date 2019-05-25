@extends('administrator.layouts.master-statistics')

@section('title', 'إعادة تعيين معلومات إستعادة كلمة المرور')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/reset-student-email.css') }}" />
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

    @if($errors->any())
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="rtl mb-0 text-danger text-right">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="modal fade" id="warning-model" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header text-right">
                        <h4 class="modal-title text-danger close" data-dismiss="modal" style="float: right;">تنبيه!</h4>
                    </div>
                    <div class="modal-body text-center">
                        <p class="text-danger">عند تغير البريد الإلكتروني الطالب سوف يكون قادر على تغير كلمة المرور</p>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success" id="agree-warning">موافق</button>
                        <button class="btn btn-danger" id="cancel-warning">إلغاء</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 animatedParent animateOnce z-index-50">
            <div class="panel panel-default animated fadeInUp">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">إعادة تعيين معلومات إستعادة كلمة المرور</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="container-fluid">
                            <form method="post" action="{{ route('administrator.student.reset.email.update', $student->username) }}" id="reset-email-form">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PUT">
                                <div class="row form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="old_password" class="col-form-label required-field">البريدالإلكترني القديم</label>
                                        <input type="email" id="old_email"
                                               class="form-control {{ $errors->has('old_email') ? 'is-invalid' : '' }} custom-input text-center"
                                               name="old_email" value="{{ $student->email }}"
                                               placeholder="البريد الإلكتروني" autocomplete="off" required>
                                        @if ($errors->has('old_password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('old_email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="password" class="col-form-label required-field">البريد الإلكترني الجديد</label>
                                        <input type="email" id="email"
                                               class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }} custom-input text-center"
                                               name="email" value="{{ old('email') }}"
                                               placeholder="البريد الإلكترني الجديد" autocomplete="off" required>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <label for="email_confirmation" class="col-form-label required-field">تأكيد البريد الإلكتروني الجديد</label>
                                        <input type="email" id="email_confirmation"
                                               class="form-control {{ $errors->has('email_confirmation') ? 'is-invalid' : '' }} custom-input text-center"
                                               name="email_confirmation" value="{{ old('email_confirmation') }}" placeholder="تأكيد البريد الإلكتروني الجديد"
                                               autocomplete="off" required>
                                        @if ($errors->has('email_confirmation'))
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email_confirmation') }}</strong>
                                                </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="row form-group mt-20">
                                    <div class="col-lg-4 col-lg-offset-4">
                                        <button class="btn btn-block custom-btn" id="save-changes">حفظ</button>
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

@section('script-file')
    <script src="{{ asset('js/administrator/reset-student-email.js') }}"></script>
@endsection