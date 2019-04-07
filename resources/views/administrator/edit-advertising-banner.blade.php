@extends('administrator.layouts.master-statistics')

@section('title', 'تعديل بانر')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/administrator/edit-banner.css') }}">
@endsection

@section('script-file')
    <script src="{{ asset('js/administrator/edit-banner.js') }}"></script>
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
                    <h3 class="panel-title">تعديل تفاصيل بانر اعلان</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-plus"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="container-fluid">
                            <form method="post" action="{{ route('administrator.advertising.banner.update', $banner->id) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PUT">

                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-2 col-sm-6 col-xs-6">
                                        <div class="pr-10 w-100">
                                            <img class="img-rounded img-thumbnail w-100 h-300-px" id="barcode"
                                                 src="/storage/banner-images/{{ $banner->banner }}">
                                        </div>


                                        <div class="form-group mt-20">
                                            <label class="required-field pr-10" for="banner-image">صورة البانر</label>
                                            <input type="text" id="banner-image"
                                                   class="form-control custom-input text-center"
                                                   placeholder='اختر صورة البانر' readonly/>
                                            <input type="file" class="opacity-0" name="banner-image" accept="image/png, image/jpg" onchange="readCover(this);">
                                        </div>

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label class="required-field pr-10" for="title">العنوان</label>
                                            <input type="text" class="form-control custom-input" value="{{ $banner->title }}"
                                                   id="title" maxlength="20" placeholder="العنوان"
                                                   minlength="5"
                                                   name="title" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label class="required-field pr-10" for="link">الرابط</label>
                                            <input type="text" class="form-control custom-input" value="{{ $banner->link }}"
                                                   id="link" maxlength="20" placeholder="الرابط"
                                                   minlength="5"
                                                   name="link" autocomplete="off">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label class="required-field pr-10" for="description">الوصف</label>
                                            <input type="text" class="form-control custom-input" value="{{ $banner->description }}"
                                                   id="description" maxlength="30" placeholder="الوصف"
                                                   minlength="5"
                                                   name="description" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-4 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label class="required-field pr-10" for="status">إظهار البانر</label>
                                            <select class="form-control custom-input"
                                                    id="status"
                                                    name="status" required>
                                                @if($banner->status == 1)
                                                    <option value="1" selected>مفعل</option>
                                                    <option value="0">غير مفعل</option>
                                                @else
                                                    <option value="1">مفعل</option>
                                                    <option value="0" selected>غير مفعل</option>
                                                @endif
                                            </select>
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