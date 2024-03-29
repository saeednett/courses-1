@extends('center.layouts.master-v-1-1')

@section('title', 'إضافة حساب بنكي')

@section('style-file')
    <link rel="stylesheet" href="{{ asset('css/center/edit-bank-account.css') }}">
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
                    <h3 class="panel-title">إضافة حساب بنكي</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-plus"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div class="container-fluid">
                            <form method="post" action="{{ route('center.bank.account.store') }}">
                                {{ csrf_field() }}

                                <div class="row form-group">
                                    <div class="col-lg-3">
                                        <label class="col-form-label required-field" for="account_owner">اسم
                                            صاحب
                                            الحساب</label>
                                        <input type="account_owner" id="account_owner"
                                               class="form-control custom-input text-center" value="{{ old('account_owner') }}" maxlength="50" minlength="10"
                                               name="account_owner" placeholder="اسم صاحب الحساب" autocomplete="off" required>
                                    </div>

                                    <div class="col-lg-3">
                                        <label class="col-form-label required-field" for="account_number">رقم
                                            الحساب</label>
                                        <input type="text" id="account_number" class="form-control custom-input text-center"
                                               value="{{ old('account_number') }}"
                                               name="account_number" maxlength="25" minlength="15"
                                               placeholder="رقم الحساب" autocomplete="off" required>
                                    </div>

                                    <div class="col-lg-3">
                                        <label class="col-form-label required-field"
                                               for="main-bank">البنك</label>
                                        <select id="main-bank"
                                                class="form-control {{ $errors->has('bank') ? 'is-invalid' : '' }} custom-input"
                                                name="bank" required>
                                            @foreach($banks as $bank)
                                                @if ( old('bank') == $bank->id )
                                                    <option value="{{ $bank->id }}" selected>{{ $bank->name }}</option>
                                                @else
                                                    <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="col-form-label op-0" for="bank">المزيد</label>
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
    <script src="{{ asset('js/center/edit-bank-account.js') }}"></script>
@endsection