@extends('center.master-v-1-1')

@section('title', 'إضافة حساب منصة هللة')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/edit-halalah-account.css') }}">
@endsection

@section('script-file')
    <script src="{{ asset('js/center/edit-halalah-account.js') }}"></script>
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
                    <h3 class="panel-title">إضافة حساب منصة هللة</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-plus"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="container-fluid">
                            <form method="post" action="{{ route('center.halalah.account.store') }}"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-2 col-sm-6 col-xs-6">
                                        <div class="pr-10 w-100">
                                            <img class="img-rounded img-thumbnail w-100 h-300-px" id="barcode"
                                                 src=" {{ asset('img/student/default.png') }}">
                                        </div>


                                        <div class="form-group mt-20">
                                            <label class="required-field pr-10" for="barcode-image">صورة
                                                الباركود</label>
                                            <input type="text" id="barcode-image"
                                                   class="form-control custom-input text-center"
                                                   placeholder='اختر صورة الباركود' readonly/>
                                            <input type="file" class="opacity-0" name="barcode-image"
                                                   accept="image/png, image/jpg" onchange="readCover(this);">
                                        </div>

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-2 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label class="required-field pr-10" for="account_owner">اسم المستخدم</label>
                                            <input type="text" class="form-control custom-input" value="{{ old('account_owner') }}"
                                                   id="account_owner" maxlength="50" placeholder="اسم صاحب الحساب"
                                                   name="account_owner" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6 col-lg-offset-3 col-md-4 col-md-offset-2 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label class="required-field pr-10" for="status">حالة الحساب</label>
                                            <select class="form-control custom-input"
                                                    id="status"
                                                    name="status" required>
                                                <option value="1">مفعل</option>
                                                <option value="0">غير مفعل</option>
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