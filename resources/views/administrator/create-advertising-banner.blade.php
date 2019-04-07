@extends('administrator.layouts.master-statistics')

@section('title', 'إضافة اعلان')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/create-banner.css') }}">
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
                    <h3 class="panel-title">إضافة تفاصيل بانر اعلان</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-plus"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="container-fluid">
                            <form method="post" action="{{ route('administrator.advertising.banner.store') }}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-2 col-sm-6 col-xs-6">
                                        <div class="pr-10 w-100">
                                            <img class="img-rounded img-thumbnail w-100 h-300-px" id="barcode"
                                                 src="{{ asset('img/main/default.jpg') }}">
                                        </div>


                                        <div class="form-group mt-20">
                                            <label class="required-field pr-10" for="banner-image">صورة البانر</label>
                                            <input type="text" id="banner-image"
                                                   class="form-control custom-input text-center {{ $errors->has('banner-image') ? 'is-invalid' : '' }}"
                                                   placeholder='اختر صورة البانر' readonly/>
                                            <input type="file" class="opacity-0" name="banner-image" accept="image/png, image/jpg" onchange="readCover(this);">
                                            @if ($errors->has('banner-image'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('banner-image') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label class="required-field pr-10" for="title">العنوان</label>
                                            <input type="text" class="form-control custom-input {{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ old('title') }}"
                                                   id="title" maxlength="20" placeholder="العنوان"
                                                   minlength="5"
                                                   name="title" autocomplete="off">
                                            @if ($errors->has('title'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label class="required-field pr-10" for="link">الرابط</label>
                                            <input type="text" class="form-control custom-input ltr {{ $errors->has('link') ? 'is-invalid' : '' }}" value="{{ old('link') }}"
                                                   id="link" maxlength="50" placeholder="الرابط"
                                                   minlength="5"
                                                   name="link" autocomplete="off">
                                            @if ($errors->has('link'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('link') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label class="required-field pr-10" for="description">الوصف</label>
                                            <input type="text" class="form-control custom-input {{ $errors->has('description') ? 'is-invalid' : '' }}" value="{{ old('description') }}"
                                                   id="description" maxlength="30" placeholder="الوصف"
                                                   minlength="5"
                                                   name="description" autocomplete="off">
                                            @if ($errors->has('description'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('description') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-4 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label class="required-field pr-10" for="status">إظهار البانر</label>
                                            <select class="form-control custom-input {{ $errors->has('status') ? 'is-invalid' : '' }}"
                                                    id="status"
                                                    name="status" required>
                                                @if(old('status') == 1)
                                                    <option value="1" selected>مفعل</option>
                                                    <option value="0">غير مفعل</option>
                                                @elseif(old('status') == 0)
                                                    <option value="1">مفعل</option>
                                                    <option value="0" selected>غير مفعل</option>
                                                @else
                                                    <option value="1">مفعل</option>
                                                    <option value="0">غير مفعل</option>
                                                @endif
                                            </select>
                                            @if ($errors->has('status'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
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

@section('script-file')
    <script src="{{ asset('js/administrator/create-banner.js') }}"></script>
@endsection