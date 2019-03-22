@extends('center.master-v-1-1')

@section('title', 'حسابات التواصل الإجتماعي')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/edit-social-media-account.css') }}">
@endsection

@section('content')
    @if($errors->any())
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-danger animated fadeInUp">
                    <ul class="text-right rtl mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    @if(session()->has('success'))
        <div class="row">
            <div class="col-lg-12 animatedParent animateOnce z-index-50">
                <div class="alert alert-success animated fadeInUp">
                    <ul class="text-right rtl mb-0">
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
                    <h3 class="panel-title">تعديل معلومات التواصل الإجتماعي</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-plus"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="container-fluid">
                            <form method="post" action="{{ route('center.social.media.account.update') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PUT">
                                <?php $counter = 1; ?>

                                @foreach($center_social_media as $social)
                                    <div class="row">

                                        <div class="col-lg-4 col-lg-offset-2 col-md-4 col-md-offset-2 col-sm-6 col-xs-6">
                                            <label class="col-form-label required-field"
                                                   for="{{ $social->socialMediaInformation->name }}">موقع التواصل
                                                الإجتماعي</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-{{ strtolower($social->socialMediaInformation->name)  }}"></i></span>
                                                <input type="text"
                                                       class="form-control custom-input"
                                                       id="{{ $social->socialMediaInformation->name }}"
                                                       value="{{ $social->socialMediaInformation->name }}"
                                                       autocomplete="off" disabled readonly required>
                                            </div>
                                        </div>


                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <label class="col-form-label required-field"
                                                       for="{{ $social->socialMediaInformation->name."_username" }}">اسم
                                                    المستخدم</label>
                                                <input type="text" class="form-control custom-input"
                                                       id="{{ $social->socialMediaInformation->name."_username" }}"
                                                       minlength="5" maxlength="20"
                                                       name="{{ strtolower($social->socialMediaInformation->name)."_username" }}"
                                                       value="{{ $social->username }}" autocomplete="off">
                                            </div>
                                        </div>

                                        <?php $counter++; ?>
                                    </div>

                                @endforeach
                                <div id="accounts">

                                </div>

                                <div class="row form-group">
                                    <div class="col-lg-4 col-lg-offset-4">
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
        </div>
    </div>
@endsection